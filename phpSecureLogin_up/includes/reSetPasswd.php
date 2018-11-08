<?php
include_once 'db_connect.php';
include_once 'functions.php';

echo "hello now you can reset your password";
echo "</br>";
$email_old = $_GET['key'];
echo "</br>";
$otp1 = $_GET['reset'];
$qry = "select * from login_attempts WHERE email = '".$email_old."';";
echo $qry;
$out = $mysqli->query($qry);
// echo $out;

if($out->num_rows > 0){
	echo "helooooooo";
	  while ($row = $out->fetch_assoc()){
    		echo $row['user_id'];
    		$otp2 = $row['otp'];
			 $email = $row['plainEmail'];
       $time = $row['time'];

		}
    // echo "hello 2";

      if($otp1 == $otp2){
      	echo "good ";
      	$time_taken = time() - $time;
      	if($time_taken>3600){
      		echo "time out !!";
      	}
      	else{
      		$q = "Location:enterPasswd.php?email=".$email_old;
      		header($q);	
      	}
      }
      else{
      	echo " something went wrong!!";
      }
    
}
else{
	echo "no query found";
}
?>