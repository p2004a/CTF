package main

import (
	"bufio"
	"bytes"
	"fmt"
	"io/ioutil"
	"log"
	"net"
)

type Result struct {
	data []byte
	id   int
}

func get_range(id, offset, length int, ret chan<- Result, sem chan bool) {
	<-sem

	conn, err := net.Dial("tcp", "2edba7.hack.dat.kiwi:80")
	if err != nil {
		log.Fatal("Couldn't download", err)
	}
	defer conn.Close()

	fmt.Fprintf(conn, "GET /web/kiwi-forum2/avatar?id=1 HTTP/1.1\r\nHost: 2edba7.hack.dat.kiwi\r\nRange: bytes=%d-%d\r\n\r\n", offset, offset+length+1)
	reader := bufio.NewReader(conn)

	for line := ""; line != "\r\n"; {
		line, err = reader.ReadString('\n')
		if err != nil {
			log.Fatal("Couldn't read: ", err)
		}
	}

	buf := make([]byte, length)
	for readed := 0; readed < length; {
		read, err := reader.Read(buf[readed:])
		if err != nil {
			log.Fatal("Error in writing payload: ", err)
		}
		readed += read
	}

	sem <- true

	ret <- Result{data: buf, id: id}
}

func main() {
	file_size := 7020062
	chunk_size := 600
	num_parallel := 200
	num_chunks := (file_size + chunk_size - 1) / chunk_size

	results := make([][]byte, num_chunks)

	sem := make(chan bool, num_parallel)
	for i := 0; i < num_parallel; i++ {
		sem <- true
	}

	result_chan := make(chan Result, 20)

	for i := 0; i < file_size; i += chunk_size {
		length := chunk_size
		if i+length > file_size {
			length = file_size - i
		}

		go get_range(i/chunk_size, i, length, result_chan, sem)
	}

	for i := 0; i < num_chunks; i++ {
		fmt.Printf("%d/%d\r", i, num_chunks)
		result := <-result_chan
		results[result.id] = result.data
	}
	fmt.Print("\n")

	whole_file := bytes.Join(results, []byte{})

	err := ioutil.WriteFile("out.bmp", whole_file, 0644)
	if err != nil {
		log.Fatal("Error in writing file", err)
	}
}
