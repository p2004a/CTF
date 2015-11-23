<?php
function SecureRandom()
{
    if (function_exists("openssl_random_pseudo_bytes") && FALSE)
        $random32bit=(int)(hexdec(bin2hex(openssl_random_pseudo_bytes(64))));
    else
    {
    	static $seeded=false;
    	if (!$seeded)
    	{
    		$seeded=true;
            list ($usec, $sec)=explode(" ",microtime());
            $usec*=1000000;
            mt_srand($usec);
        }

        $random32bit=mt_rand();
    }
    return $random32bit;
}

function RandomString($length=32)
{
	$res="";
	for ($i=0;$i<$length;$i+=16)
		$res.=substr(md5(SecureRandom()),0,16);
	return substr($res,0,$length);
}