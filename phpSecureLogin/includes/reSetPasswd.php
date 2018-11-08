<?php
include_once 'db_connect.php';
include_once 'functions.php';

echo "hello now you can reset your password";
echo "</br>";
$email = $_GET['key'];
echo "</br>";
$otp1 = $_GET['reset'];
$qry = "select * from login_attempts WHERE email = '".$email."';";
echo $qry;
$out = $mysqli->query($qry);
// echo $out;

if($out->num_rows > 0){
	// echo "helooooooo";
	 //  while ($row = mysql_fetch_assoc($out)){
	 //  		// echo "koko";
  //   		echo $row['user_id'];
  //   		$otp2 = $row['otp'];
			// $email = $row['plainEmail'];
		// }
	 $otp2 = $otp1;
      $tm = 1541626192;
      // $email = "kamlesh@iitk.ac.in";
      if($otp1 == $otp2){
      	echo "good ";
      	$time_taken = time() - $tm;
      	if($time_taken>3600){
      		echo "time out !!";
      	}
      	else{
      		$q = "Location:enterPasswd.php?email=".$email;
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