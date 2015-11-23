var crypto = require('crypto');

var salt="7e752c7f91a942f913bbbfe7bc8e997e";
var valid="fd62968754629279bce1d73398cde2f1";
//md5(salt+answer)

function md5(text) {
    return crypto.createHash('md5').update(text).digest('hex');
}

function solve(result)
{
    if (md5(salt+result)==valid)
    {
        console.log("Flag is: "+md5(salt+result+result));
    }
}


for (var i = 0; i < 10000; ++i) {
    var c = i;
    var text = '';
    for (var j = 0; j < 4; ++j) {
        var n = c % 10;
        text += n;
        c = Math.floor(c / 10);
    }
    solve(text);
}
