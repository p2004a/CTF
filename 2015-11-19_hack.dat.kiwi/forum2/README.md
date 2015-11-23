Kiwi Forum 2
============

In this challenge the first hole was fixed but analysis revealed that
[download.php](kiwi-forum-source/lib/download.php) supports `Range` HTTP
request field. With this information in mind I wrote parallel file downloader
in Go: [get.go](get.go). I took around 15min to download whole image from the
server.
