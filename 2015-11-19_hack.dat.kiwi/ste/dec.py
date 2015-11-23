#!/usr/bin/python
import png
import sys


def main(args):
    filename = args[0]
    r = png.Reader(open(filename))
    f = r.read()
    for l in f[2]:
        l = ["{:02x}".format(b) for b in l]
        print ' '.join(l)


if __name__ == '__main__':
    main(sys.argv[1:])
