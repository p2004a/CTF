#!/usr/bin/python
import png
import sys


def read_png(filename):
    r = png.Reader(open(filename))
    f = r.read()
    return list(f[2])


def diff(a, b):
    for col in range(len(a[0])):
        for row in range(len(a)):
            if a[row][col] != b[row][col]:
                yield row, col, a[row][col], b[row][col]


def main(args):
    a = read_png(args[0])
    b = read_png(args[1])

    num_diffs = 0

    for r, c, x, y in diff(a, b):
        s = '{:3d} {:3d} {:08b} {:08b} {:08b}'.format(r, c, x, y, x ^ y)
        print s
        num_diffs += 1

    print 'num diffs', num_diffs


if __name__ == '__main__':
    main(sys.argv[1:])
