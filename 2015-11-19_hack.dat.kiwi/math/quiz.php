<?php
function verbose() { 
    return isset($_GET['verbose']); 
}
if (!verbose()) ini_set("display_errors","off");
if (isset($_GET['dump'])) {    
    die(highlight_file(__FILE__)); 
}
function error_handler($errno, $errstr, $errfile, $errline) {
    echo "<strong>Error {$errno}: {$errstr} in <a style='color:inherit;text-decoration:none;' href='?dump'>{$errfile} on line {$errline}</a></strong>" ;
}
function check_for_fatal_error() 
{
    $error = error_get_last();
    $isError=false;
    switch ($error ['type'])
    {
        case E_ERROR :
        case E_CORE_ERROR :
        case E_PARSE :
        case E_COMPILE_ERROR :
        case E_USER_ERROR :
            error_handler( $error["type"], $error["message"], $error["file"], $error["line"] );
    }
}
set_error_handler("error_handler",-1);
register_shutdown_function( "check_for_fatal_error" );


require_once __DIR__."/questions.php";
function filter($expression)
{
    if (strpos($expression, ";")!==false) return null;
    $allowed_functions=explode(",","abs,ceil,cos,floor,log,max,min,md5,pi,pow,rand,round,sin,sqrt,tan");
    preg_match_all("/([a-z]+?)\s*\(/i", $expression, $matches);
    if ($matches)
        foreach ($matches[1] as $match)
            if (!in_array($match, $allowed_functions))
                return null;
    return $expression.";";
}
function evaluate($question,$answer)
{
    eval('$x='.filter($answer));
    $res=" ".$question[0];
    for ($i=1;$i<strlen($question);++$i)
    {
        if ($question[$i]=="X" and is_numeric($question[$i-1]))
            $res.="*X";
        else
            $res.=$question[$i];
    }
    $res=preg_replace("/(\d+|X)\s*\^\s*(.*?)\s/", "pow($1,$2)", $res);
    $res=str_replace("X", '$x', $res);
    
    $question=filter($res);
    if (!$question)
        return null;
    $question=str_replace("=", '==', $question);
    if (verbose()) echo $question.PHP_EOL;
    eval('$res='.$question);
    return $res;
}
function format($expression)
{
    $res="";
    $mode=null;
    for ($i=0;$i<strlen($expression);++$i)
    {
        $c=$expression[$i];
        if ($mode=="power")
            if ($c==" ")
                $c="</sup> ";
        if ($c=="^")
        {
            $c="<sup>";
            $mode="power";
        }
        elseif ($c==" ")
            $c="";
        $res.=$c;
    }
    return $res;
}
if (isset($_POST['answer']))
{
    $index=$_POST['index']*1;
    $correct=(evaluate($question[$index],$_POST['answer']));
}
else
{
    mt_srand();
    $index=mt_rand(1,count($question)-1);
}
$seed=7;
mt_srand($seed);
srand($seed);

?>
<html>
<head>
<script src="jquery-1.11.1.min.js"></script>
<title>Math Quiz</title>
<link rel="stylesheet" href='style.css'></link>
</head>
<body>
    <p><strong>Description:</strong> 
        There's a guy in my class who thinks he's a super programmer always making secure code.
        He recently made this
        math quiz web app for the class to take quizes online. I told everyone that I'd hack his site
        and bring it down, 
        but I'm a noob! Please do it for me.
    </p>
<?php if (isset($correct))
    echo $correct?"<div class='correct'>Correct!</div>":"<div class='incorrect'>Not correct.</div>";?>
<div id='questionContainer'>
    <div id='question'>
        <?php echo format($question[$index]);?>
    </div>
    <form id='answers' method='post'>
<?php 
$t=$answers[$index];
shuffle($t);
$i=0;
foreach ($t as $v)
{
    ?><input type='radio' name='answer' class='answer' value='<?php echo $v;?>'>
        <span class='answerValue'><?php echo $v;?></span>
    </input>
    <input type='hidden' name='index' value='<?php echo $index;?>' />
    <?php
}
?>
</form>
</div>
<div style='text-align:center;'><a href='./'>next</a></div>
<script>
$(".answer").click(function(e){$("#answers").submit();});
</script>
</body>
</head> 1
