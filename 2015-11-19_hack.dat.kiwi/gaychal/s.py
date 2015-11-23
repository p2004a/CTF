#!/usr/bin/python2

import subprocess
import sys


def php(code):
    proc = subprocess.Popen('php', stdout=subprocess.PIPE,
                            stdin=subprocess.PIPE)
    proc.stdin.write(code)
    proc.stdin.close()
    result = proc.stdout.read()
    proc.wait()
    return result


def main():
    with open('gaychal.php', 'r') as f:
        code = f.read()
        code = php(code)
        v = 1
        print v
        while code[:4] == 'eval':
            code = '<?php print{} ?>'.format(code[4:])
            code = php(code)
            v += 1
            print v

        print code

if __name__ == "__main__":
    main()

