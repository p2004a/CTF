Kiwi Forum
==========

The code contains a simple vulnerability allowing user to download any file
from the server by sending a path to the file in the `__r` GET variable.

The important code is in the [loader.php](kiwi-forum-source/loader.php).

By code analysis it is easy to see that doing this

````
GET /web/kiwi-forum/?__r=../db/00001.bmp HTTP/1.1
Host: 2edba7.hack.dat.kiwi

````

HTTP request will give use image that contains flag.
