<?php
function SignUp($data)
{
	lib("users");
	if (is_string($res=CreateUser($data['username'],$data['password'],$data['email'])))
		echo "<div class='error'>{$res}</div>".PHP_EOL;
	else
		echo "Done. <a href='./'>Login</a> now.".PHP_EOL;
}
if (count($_POST))
{
	$error=array();
	$data=$_POST;
	if (!preg_match("/^[a-z0-9]{3,16}$/i", $data['username']))
		$error[]="Invalid username. Use only alphanumerics.";
	if ($data['password']!=$data['retype'])
		$error[]="Invalid password retype.";
	if (strlen($data['password'])<4)
		$error[]="Password too short.";
	if (!isset ($_SESSION['signup_captcha']) or $_SESSION['signup_captcha']!==$data['captcha'])
		$error[]="Invalid CAPTCHA.";
	if (!preg_match("/^.+?@.+?\..+?$/", $data['email']))
		$error[]="Please provide valid email.";

	unset($_SESSION['signup_captcha']);



	if (empty($error))
		SignUp($data);
}

?>
<html>
<head>
<link rel='stylesheet' href='style.css'></link>

</head>
<body>
<?php
if (!empty($error))
	foreach ($error as $err)
		echo "<div class='error'>{$err}</div>".PHP_EOL;
?>
<form method='post' id='signup'>
	<label>Username</label> <input type='text' name='username' placeholder='username' value=''/>
	<br/>
	<label>Email</label> <input type='text' name='email' placeholder='E-Mail' value=''/>
	<br/>
	<label>Password</label> <input type='password' name='password' />
	<br/>
	<label>Password Retype</label> <input type='password' name='retype' />
	<br/>
	<label>CAPTCHA</label> <input type='text' name='captcha' />
	<img src='captcha?t=signup' height="16"/>
	<br/>
	<input type='submit' value='Register'/>
</body>
</html>

