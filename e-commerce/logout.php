<?php

Session_destroy();

$host = "localhost";
$user = "root";
$password = "dbpass";
$dbname = "ACME";
$con = new mysqli($host, $user, $password, $dbname)
        or die('Could not connect to the database server. ' . mysqli_connect_error($con));
if ($con->connect_error == FALSE) {
    echo"<a href='login.php'>Login</a><br>";
    echo "<a href='createaccount.php'>Create an Account</a><br>";
    echo "You've been logged out!";
} else {
    echo $con->connect_error;
}


?>


