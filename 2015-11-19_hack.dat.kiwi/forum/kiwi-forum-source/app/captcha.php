<?php
lib("purecaptcha");

$captcha=new PureCaptcha();
if (isset($_GET['t']))
	$index=$_GET['t']."_captcha";
else
	$index="captcha";
$_SESSION[$index]=$captcha->show();