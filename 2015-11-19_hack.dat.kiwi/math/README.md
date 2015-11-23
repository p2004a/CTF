Math Quiz
=========

My solution to this problem was sending the `$GLOBALS['index']=0` string as
an answer. The `$index` is assigned in line 87 of [quiz.php](quiz.php)
but the answer was evaluated in line 88 so in line 118 and 122 the `$index`
was equal to `0` thus printing the flag hidden as one of the answers to
question.

