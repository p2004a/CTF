<?php
function lib($lib)
{
	require_once __DIR__."/lib/{$lib}.php";
}
function neat($string)
{
	return htmlspecialchars($string, ENT_COMPAT | ENT_HTML401);
}
session_start();
if (!is_writable(__DIR__."/db"))
	echo "Warning: db folder is not writable.".PHP_EOL;
lib("sql");
//DB setup
$creds=array("username"=>"root","password"=>"****","dbname"=>"kiwi-forum");
$db = new PDO('mysql:host=localhost', $creds['username'], $creds['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
if (sql("SHOW DATABASES LIKE '{$creds['dbname']}'"))
	sql("use `{$creds['dbname']}`");
else
	require_once __DIR__."/db_setup.php";
unset($creds);
