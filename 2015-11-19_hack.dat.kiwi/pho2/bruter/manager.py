#!/usr/bin/python2
import sys
import urllib2
import re
import random
import subprocess32 as subprocess
import md5
import time
import datetime

BTN_RE = re.compile(r'<a class="button b(l|1)">(\d)</a>')
SALT_RE = re.compile(r'salt ="([0-9a-f]{24})xxxxxxxx"')
VALID_RE = re.compile(r'valid="([0-9a-f]{18})xxxxxxxxxxxxxx"')


def get_data():
    url = 'http://2edba7.hack.dat.kiwi/web/phone-lock2/'
    website = urllib2.urlopen(url).read()

    buttons = BTN_RE.findall(website)
    assert len(buttons) == 10
    selected = [btn[1] for btn in buttons if btn[0] == '1']

    salt_match = SALT_RE.search(website)
    assert salt_match is not None
    salt = salt_match.group(1)

    valid_match = VALID_RE.search(website)
    assert valid_match is not None
    valid = valid_match.group(1)

    return (selected, salt, valid)


def run_brut(salt, valid, nums, timeout=50):
    try:
        result = subprocess.check_output(['./brut', salt, valid, nums],
                                         timeout=timeout)
        if len(result) == 32:
            return result
    except subprocess.TimeoutExpired:
        pass
    return None


def solve():
    selected, salt, valid = get_data()

    random.shuffle(selected)
    while len(selected) < 4:
        selected.append(selected[-1])
    selected_str = ''.join(selected)

    print '-- running brut --'
    print 'salt: ', salt
    print 'valid: ', valid
    print 'nums: ', selected_str

    result = run_brut(salt, valid, selected_str)
    if result is not None:
        print 'full valid: ', result
        print 'FLAG: ', md5.new(selected_str + result).hexdigest()
        return True
    else:
        print 'fail.'
        return False


def play_sound():
    subprocess.check_output(['mplayer', 'timealarm.wav'],
                            stderr=subprocess.STDOUT)


def wait_for_round_time():
    now = datetime.datetime.now()
    if now.second < 2:
        return
    time.sleep(60.5 - now.second)


def main(args):
    while True:
        wait_for_round_time()
        print 'new round'
        if solve():
            play_sound()


if __name__ == '__main__':
    main(sys.argv)
