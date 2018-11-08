<?php
/**
 * Copyright (C) 2013 peredur.net
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            
        </ul>
        
        <?php echo esc_url($_SERVER['PHP_SELF']); ?>

        
        <form method="post" name="registration_form" action="">
            Username: <input type='text' name='username' id='username' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            
            <input type="submit" 
                   value="Next" 
                   name="submit0"><br><br>

        </form>

<?php

$servername = "localhost";
$username = "cs252";
$password = "cs252";
$database = "users";

// Create connection
$conn = new mysqli($servername, $username, $password , $database);

// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

else
{
    echo "connected successfuly";
    echo "</br>";


}


if(isset($_POST["submit0"])){

    $uname = $_POST['username'];
    $email = $_POST['email'];

    
    $q = "select * from members where username='".$uname."';";
    
    //echo $q;
    
    $result = $conn->query($q);


    if ($result->num_rows > 0) {
        
        echo "USERNAME ALREADY TAKEN!!!<br><br>Suggested Username";

        $num1 = mt_rand(1,999);           
        $num2 = mt_rand(1,999);

        $q1 = "select * from members where username='".$uname.$num1."';";

        // echo $q1;

        $result1 = $conn->query($q1);

        while($result1->num_rows > 0){

            $num1 = mt_rand(1,999);            
            $q1 = "select * from members where username='".$uname.$num1."';";

            $result1 = $conn->query($q1);
            
        }

        $uname1 = $uname.$num1 ;

        // echo "uname is".$uname1;

        $q1 = "select * from members where username='".$uname.$num2."';";

        // echo $q1;

        $result1 = $conn->query($q1);

        while($result1->num_rows > 0){

            $num2 = mt_rand(1,999);            
            $q1 = "select * from members where username='".$uname.$num2."';";

            $result1 = $conn->query($q1);
            
        }

        $uname2 = $uname.$num2 ;


        echo "<br>".$uname1 ;
        echo "<br>".$uname2."<br>" ;
        

    } else {
        echo "Proceed for Next Step \n<br>";
        $direct = "register2.php";
        header("Location:".$direct."?username=".$uname. "&email=".$email);
    }
    
}

?>


<?php 

            echo $_POST['']

        ?>



        <p>Return to the <a href="index.php">login page</a>.</p>
    </body>
</html>
