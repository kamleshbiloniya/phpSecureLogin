<?php
include_once 'db_connect.php';
include_once 'functions.php';

// echo "namste";
echo "</br>";
if(isset($_POST["submit"])){
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	echo $email;
	$q = "select * from members WHERE email='".$email."';";
	// echo "</br>";
	// echo $q;
	$sq1 = $mysqli->query($q);
	if($sq1->num_rows > 0){
		echo "<p style='color:green;'>";
		echo "Plese check email";
		echo "</p>";
		echo "</br>";

		require '/var/www/html/PHPMailer_v5.1/class.phpmailer.php';
		
		$r = rand();
		$hemail=md5($row['email']);
        $pass=md5($r);
    	$time = time();
        $link="<a href='http://localhost/phpSecureLogin/includes/reSetPasswd.php?key=".$hemail."&reset=".$pass."'>Click To Reset password</a>";
    	$qry = "select * from login_attempts WHERE email = '".$hemail."';";
    	$out = $mysqli->query($qry);
    	if($out->num_rows>0){
    		//update 
    		// echo "from update";
    		// echo "</br>";
    		$qry = "UPDATE login_attempts SET otp = '".$pass."', time =".$time." WHERE email = '".$hemail."';";
    		// echo $qry;
    		$out = $mysqli->query($qry);
    		if($out===TRUE){
    			echo "<p>token update done successfully</p>";
    			
    		}
    		else{
    			echo "<p>token update fail try again</p>";
    		}
    	}else{
    		// echo "from insert time =";
    		echo $time;
    		$qry = "INSERT INTO login_attempts (user_id,time,otp,email,plainEmail) VALUES (1,".$time.",'".$pass."','".$hemail."','".$email."')";
    		// echo "</br>";
    		// echo $qry;
    		$out = $mysqli->query($qry);
    		if ($out===TRUE) {
    			echo "<p>token insertition done successfully</p>";
    		}
    		else{
    			echo "<p>token insertition fail</p>";	
    		}
    	}
   

		$mail             = new PHPMailer();

		$body             = "<h1>hello, world!</h1>".$link;

		$mail->IsSMTP(); // telling the class to use SMTP

		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "";  // GMAIL username
		$mail->Password   = "";            // GMAIL password //https://myaccount.google.com/lesssecureapps

		$mail->SetFrom('', 'Kamlesh');

		$mail->AddReplyTo("","KK biloniya");

		$mail->Subject    = "PHPMailer Test Subject via smtp (Gmail)";

		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

		$mail->MsgHTML($body);

		echo $email;
		$mail->AddAddress($email, "Biloniya");

		if(!$mail->Send()) {
		  echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		  echo "<p>Message sent!</p>";
		  echo "</br>";
		  echo "<form action='' method='post' name='varify'>";
		  echo "<input type='submit' name='submit'>";
		  echo "</form>";
		}
	}
	else{
		echo "<p style='color:red;'>";
		echo "Email address not found in database.Please try again";
		echo "</p>";
		echo "<form action='' method='post'' name='sendMail'>";
		echo "<p>Enter your Email address. You will receive an email with a link to reset your password</p>";
		echo  "<input type='text' name='email'>";
		echo "<input type='submit' name='submit'>";
		echo "</form>";
	}
}
else{
	echo "<form action='' method='post'' name='sendMail'>";
	echo "<p>Enter your Email address. You will receive an email with a link to reset your password</p>";
	echo  "<input type='text' name='email'>";
	echo "<input type='submit' name='submit'>";
	echo "</form>";
}

?>

