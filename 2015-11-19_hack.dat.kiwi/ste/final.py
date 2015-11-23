#!/usr/bin/python
import png
import sys


def chunks(l, chunk_size):
    """Returns n-sized chunks from l."""
    res = []
    for i in range(0, len(l), chunk_size):
        res.append(l[i:i + chunk_size])
    return res


def read_png(filename):
    r = png.Reader(open(filename))
    f = r.read()
    return list(f[2])


def dec(a):
    bits = []
    for col in range(len(a[0])):
        for row in range(len(a)):
            v = a[row][col]
            if v > 0:
                bits.append(v & 1)

    bytes = chunks("".join(map(str, bits)), 8)
    if len(bytes[-1]) != 8:
        bytes.pop()

    bytes = [int(byte, 2) for byte in bytes]

    return "".join(map(chr, bytes))


def main(args):
    a = read_png(args[0])

    print dec(a)


if __name__ == '__main__':
    main(sys.argv[1:])
