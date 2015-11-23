<?php

/*
This file constains my attempts to run the function in eval after filtering.
*/

function filter($expression)
{
    if (strpos($expression, ";")!==false) return null;
    $allowed_functions=explode(",","abs,ceil,cos,floor,log,max,min,md5,pi,pow,rand,round,sin,sqrt,tan");
    preg_match_all("/([a-z]+?)\s*\(/i", $expression, $matches);
    if ($matches)
        foreach ($matches[1] as $match) {
            if (!in_array($match, $allowed_functions))
                return null;
        }
    return $expression.";";
}

$a = puts;

$a('asd');

$t = '(((1 == 1) ? puts : puts)(((1 == 1) ? file_get_contents : file_get_contents)(__DIR__."/quiz.php")))';

//$x = (((1 ? file_get_contents : 0)(__DIR__."/quiz.php")));

$t = "file_get_contents('asd')";

$after = filter($t);

echo $after . "\n";

eval('$x='.$after);

?>
