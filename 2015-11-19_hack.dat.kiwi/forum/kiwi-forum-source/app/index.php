<?php
if (isset($_GET['logout']))
{
	unset($_SESSION['user']);
	header("location: ?");
}
if (isset($_POST['username']))
{
	lib("users");
	if (is_string($res=Login($_POST['username'],$_POST['password'])))
		echo "<div class='error'>{$res}</div>".PHP_EOL;
}
?>
<html>
<head>
<link rel='stylesheet' href='style.css'></link>
</head>
<body>
<h2>Kiwi Forum</h2>
<?php
if (!isset($_SESSION['user'])){
	?>
<form method='post'>
	<input type='text' name='username' placeholder='username' value=''/>
	<br/>
	<input type='password' name='password' />
	<br/>
	<input type='submit' value='Login'/>
	<a href='signup'>Sign Up</a>
</form>
<?php
}
else
{
	?>
	Welcome <?php echo neat($_SESSION['user']['username']);?>!
	<a style='float:right;' href='?logout'>Logout</a>
	<?php

	if (isset($_POST['content']) and isset($_POST['subject']) and $_POST['subject']  )
	{

		if (isset($_SESSION['post_captcha']) and $_SESSION['post_captcha']===$_POST['captcha'])
			sql("INSERT INTO posts (owner,subject,content,timestamp) VALUES (?,?,?,?)",$_SESSION['user']['ID'],$_POST['subject'],$_POST['content'],time());
		else
			$captcha_error=true;
		
	}


	$post_per_page=2;
	$pages=ceil(sql("SELECT COUNT(*) AS Result FROM posts")[0]['Result']/$post_per_page);
	if (isset($_GET['page']))
		$page=$current_page=$_GET['page']*1;
	else 
		$page=max(0,$current_page=$pages-1);
	$page*=$post_per_page;
	$posts=sql("SELECT * FROM posts JOIN users ON (posts.owner=users.id) ORDER BY timestamp ASC LIMIT {$page},{$post_per_page}");
	echo "<div id='posts'>\n";
	if ($posts)
	foreach ($posts as $post)
	{
		if ($post['access']) $color=" style='color:red;'";
		else $color="";
		echo "<div class='post'>
		<div class='avatar'><a class='photo'>
			<img width='32' src='avatar?id=".$post['owner']."' /></a>
		<br/><strong>".neat($post['username'])."</strong></div>
		<strong>".neat($post['subject'])."</strong><br/><span{$color}>".neat($post['content'])."</span><span class='date'>".date("Y-m-d H:i:s",$post['timestamp'])."</span>
		</div>\n";
	}
	echo "</div>\n";
	echo "<div id='pages'>";
	if ($pages>1)
	for ($page=0;$page<$pages;++$page)
		if ($page==$current_page)
			echo ($page+1);
		else
			echo "<a href='?page=".($page)."'>".($page+1)."</a> ";
	echo "</div>\n";
	?>
	<fieldset>
		<?php
		if (isset($captcha_error)) 
			echo "<span class='error'>Invalid CAPTCHA.</span>";
		?>
		<legend>New Post</legend>
	<form method='post'>
		<label>Title</label><input type='text' name='subject' /><br/>
		<textarea name='content' rows='5'></textarea><br/>
		<label>CAPTCHA</label> <input type='text' name='captcha' />
			<img src='captcha?t=post' height="16"/>
			<br/>
		<input type='submit' />
	</form>
	</fieldset>
	<?php


}
?>
</body>
</html>

