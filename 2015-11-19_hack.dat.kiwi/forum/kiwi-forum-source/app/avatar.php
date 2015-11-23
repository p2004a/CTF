<?php
lib("users");
session_write_close();
$id=$_GET['id']*1;
$isAdmin=$_SESSION['user']['access'];
$initial_time=time();
function timeout()
{
	global $initial_time;
	static $timeout=null;
	if ($timeout===null) $timeout=rand(3,10);
	if (time()-$initial_time>$timeout) 
	{
		flush();
		die();
	}
}
if (!$isAdmin)
	declare(ticks=1);

	lib("download");

if (!$isAdmin)
	register_tick_function("timeout");
$dl=new \jf\DownloadManager();

if (!$isAdmin)
{
	$dl::$BandwidthLimitSpeed=1024/8; //128 bytes
	$dl::$BandwidthLimitInitialSize=1024; //1KB
}	
$dl->Feed(AvatarFile($id));
