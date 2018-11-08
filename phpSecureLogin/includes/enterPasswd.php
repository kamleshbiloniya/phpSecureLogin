<?php
include_once 'db_connect.php';
include_once 'functions.php';
// include_once 'reSetPasswd.php';

if(isset($_POST['submit'])){
	echo "ohh yeah";
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$salt = rand();
	$password = hash('sha512', $pass1 . $salt);
	if(md5($pass2)==md5($pass1)){
		$q = "select plainEmail from login_attempts WHERE email = '".$email."';";
		echo $q;
		$email = $mysqli->query($q);
		$qry = "UPDATE members password = '".$password."',salt='".$salt."' WHERE email = '".$email."';";
		$out = $mysqli->query($qry);
		if($out===TRUE){
			echo "Password updated successfully";
			echo "<a href=../index.php>Click hare to login</a>";
		}
	}
	else{
		echo "re entered password did not matched . Please try again";
	}
	
}
else{
	$email = $_GET['email'];
}

?>
<form action="enterPasswd.php" method="post" name="reset">
	Enter Password :<input type="Password" name="pass1">
	<br>
	Re Enter Password:<input type="Password" name="pass2">
	<input type="button" name="submit" value="submit">
</form>