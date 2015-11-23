<?php
function AvatarFile($ID)
{
	return 	$file=realpath(__DIR__."/../db/")."/".str_pad($ID, 5,"0",STR_PAD_LEFT).".bmp";
}
function GenerateUserKey($ID,$admin)
{
	lib ("purecaptcha");

	$key=implode("\n",str_split(RandomString("16"),6));
	$textRender=new PureTextRender();
	list($width,$height)=$textRender->text_size($key);
	$bitmap=$textRender->text_bitmap($key);
	if ($admin)
	{
		ini_set("memory_limit",-1);
		ini_set("max_execution_time",-1);
		$scale=200;
		$bitmap=$textRender->scale_bitmap($bitmap,$width,$height,$scale,$scale);
		$width*=$scale;
		$height*=$scale;
	}
	$bmpdata=$textRender->generate_bitmap($width,$height,$bitmap);
	$file=AvatarFile($ID);
	file_put_contents($file, $bmpdata);
	return true;
}
function CreateUser($username,$password,$email,$admin=false)
{
	if (sql("SELECT * from users WHERE username=?",$username))
		return "Username already in use.";
	lib("random");
	$salt=RandomString(32);
	$password=md5($salt.$password);
	$access=($admin===true);
	$ID=sql("INSERT INTO users (username,password,salt,email,access) VALUES (?,?,?,?,?)",$username,$password,$salt,$email,$access);
	if (!$ID)
		return "Unable to create user.";

	sql("INSERT INTO profile (ID,alias) VALUES (?,?)",$ID,$username);

	return GenerateUserKey($ID,$admin);
}
function Login($username,$password)
{
	$res=sql("SELECT * FROM users WHERE LOWER(username)=?",strtolower($username));

	if (!$res)
		return "Invalid credentials.";
	$res=$res[0];
	if (md5($res['salt'].$password)!==$res['password'])
		return "Invalid credentials.";
	$_SESSION['user']=$res;
	return true;
}