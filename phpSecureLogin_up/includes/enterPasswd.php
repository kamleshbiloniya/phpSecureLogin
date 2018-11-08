<?php
include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';
// include_once 'reSetPasswd.php';

if(isset($_POST['submit'])){
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$email = $_POST['hidden'];
	if(md5($pass2)==md5($pass1)){
		$q = "select * from login_attempts WHERE email = '".$email."';";
		$out = $mysqli->query($q);

		if($out->num_rows > 0){
			while ($row = $out->fetch_assoc()){
				 $email = $row['plainEmail'];

			}
		}

		$q = "select * from members WHERE email = '".$email."';";

		$out = $mysqli->query($q);
		if($out->num_rows > 0){
			while ($row = $out->fetch_assoc()){
				 $salt = $row['salt'];
				 $oldPAss = $row['password'];
				 // echo "</br>old pass :".$oldPAss;
				 // echo "</br>oldsalt :".$salt;
			}
		}
		// $pass1 = echo "hex_sha512(".$pass1.")";
		// echo "going on ";
		$password = hash('sha512', $pass1 . $salt);

		$qry = "UPDATE members SET password ='".$password."',salt='".$salt."' WHERE email='".$email."';";
		// echo $qry;
		$out = $mysqli->query($qry);
		if($out==TRUE){
			$q = "select * from members WHERE email = '".$email."';";

			$out = $mysqli->query($q);
			if($out->num_rows > 0){
				while ($row = $out->fetch_assoc()){
					 $newsalt = $row['salt'];
					 $newPAss = $row['password'];
					 // echo "</br>new password:".$newpass;
					 // echo "</br>newsalt".$newsalt;
				}
			}
			echo "<p>Password updated successfully</p>";
			echo "<a href=../index.php>Click hare to login</a>";
		}
	}
	else{
		echo "Re entered password did not matched . Please try again";
	}
	
}
else{
	$email = $_GET['email'];

	echo "<form action='enterPasswd.php' method='post' name='reset'>";
	echo "Enter Password :<input type='Password' name='pass1'>";
	echo "<br>";
	echo "Re Enter Password:<input type='Password' name='pass2'>";
	echo "<input type='hidden' name='hidden' value='".$email."'>";
	echo "<input type='submit' name='submit' value='submit' >";
	echo "</form>";
}

?>
