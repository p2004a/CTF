/* Used in eqrly stage of analysis */

function get() {
    var c = $("#pad").children();
    var l = new Array(10);
    for (var i = 0; i < 10; ++i) {
        var x = c[i].classList[1].substring(1);
        if (x == 'l') x = '0';
        l[parseInt(c[i].textContent)] = x;
    }
    return l.join('');
}

function get2() {
    var c = $("#pad").children();
    var l = new Array(10);
    for (var i = 0; i < 10; ++i) {
        var x = c[i].classList[1].substring(1);
        if (x == 'l') x = '0';
        l[parseInt(c[i].textContent)] = x;
    }
    return l.join('');
}


"0000011011"



1000101010 = 554
salt ="03af191f64e179c01b64ad15xxxxxxxx";
       5184e29383563b599b7b27265d933266
valid="8af341a74067a1d0f2xxxxxxxxxxxxxx"; //md5(salt+answer)



0100111000 = 312
salt ="feffad343464d6933c9e479bxxxxxxxx";
valid="508e2470c04d760f9fxxxxxxxxxxxxxx"; //md5(salt+answer)


//==================

1010010010
0258
salt ="f62bcc6840e39a452ca84b5dxxxxxxxx";
valid="95036d944b2c8f5b74xxxxxxxxxxxxxx"; //md5(salt+answer)


1000001101
salt ="3f333d4fbd4ffcfdb09552eexxxxxxxx";
valid="f3f2e82360bbed366bxxxxxxxxxxxxxx"; //md5(salt+answer)


1100101000
salt ="918075c71638cbc2d0011255xxxxxxxx";
valid="b13b27d6f122fc02dexxxxxxxxxxxxxx"; //md5(salt+answer)


1110010000
salt ="e1f1cb1c6d440e35ef757d09xxxxxxxx";
valid="abbdbab240f010db6fxxxxxxxxxxxxxx"; //md5(salt+answer)

