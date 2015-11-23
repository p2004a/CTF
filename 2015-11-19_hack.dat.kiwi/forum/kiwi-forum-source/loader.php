<?php
function do404()
{
	header("404 Not Found");
	echo "<h1>404 Not Found</h1>";
	echo "<p>The requested URL ".htmlspecialchars($_SERVER['REQUEST_URI'])." not found.</p>";
	exit(0);
}
$request=$_GET['__r'];
unset($_GET['__r']);
$parts=explode("/",$request);
if ($parts[count($parts)-1]=="")
	$parts[count($parts)]="index";

$file=realpath(__DIR__."/static/".implode("/",$parts));
if ($file and is_file($file))
{
	if (!$file) do404();
	require_once __DIR__."/lib/download.php";
	$x=new \jf\DownloadManager();
	$x->Feed($file);
}
else
{
	$file=realpath(__DIR__."/app/".implode("/",$parts).".php");
	if (!$file) do404();
	require_once __DIR__."/load.php";
	require $file;
}
