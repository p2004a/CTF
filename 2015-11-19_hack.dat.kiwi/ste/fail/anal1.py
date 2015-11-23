#!/usr/bin/python

import sys
from collections import namedtuple


Img = namedtuple("Img", "width, height, data")


def chunks(l, chunk_size):
    """Returns n-sized chunks from l."""
    res = []
    for i in range(0, len(l), chunk_size):
        res.append(l[i:i + chunk_size])
    return res


def loadP1(name):
    with open(name) as f:
        content = f.readlines()
        content = [x.strip() for x in content]
        content = [x for x in content if len(x) > 0 and x[0] != '#']

        if content[0] != 'P1':
            raise Exception('no header')

        w, h = tuple(map(int, content[1].split(' ')))

        bits = "".join(content[2:])

        if len(bits) != w * h:
            raise Exception('wrong width and height')

        data = chunks(bits, w)

        return Img(w, h, data)


def img_diff(a, b):
    if a.width != b.width or a.height != b.height:
        raise Exception('incomatibile')

    for r in range(0, a.height):
        for c in range(0, a.width):
            if a.data[r][c] != b.data[r][c]:
                print((r, c))


def main(args):
    images = [loadP1(f) for f in args[1:]]

    img_diff(images[0], images[1])


if __name__ == "__main__":
    main(sys.argv)
