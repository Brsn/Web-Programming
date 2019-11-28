<?php
session_start();
$host = "localhost";
$user = "root";
$password = "dbpass";
$dbname = "ACME";
$con = new mysqli($host, $user, $password, $dbname)
        or die('Could not connect to the database server. ' . mysqli_connect_error($con));
if ($con->connect_error == FALSE) {
    echo "<h2>Create an Account and Start Shopping Now!</h2>";
} else {
    echo $con->connect_error;
}

$sql = "INSERT INTO login (name, pass) VALUES('" . $_POST["name"] . "','" . $_POST["pass"] . "')";



//echo $sql;
$result = $con->query($sql);


if (!$result) {
    //something went wrong, display the error
    echo 'Something went wrong while registering. Please try again later.';
    //die($conn->error); //debugging purposes, uncomment when needed
} else {
    echo 'Already Have an Account? <br> <a href="login.php">Sign in</a>';
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>E-Commerce</title>
        <link rel="stylesheet" href="#" type="text/css">
    </head>

    <body>

        <div class="wrapper row2">
            <div id="container" class="clear">
                <!-- form -->
                <section id="slider" class="form">

                    <h2>Fill out the form!</h2>
                    <form id="Addressbook" method="post" action="createaccount.php" onsubmit="return validateForm()">
                        <table cellpadding="0" cellspacing="1">
                            <tr>
                                <td colspan="3">Create an account.
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;
                                </td>
                                <td>&nbsp;
                                </td>
                                <td>&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    First Name</td>
                                <td align="left">
                                    <input id="name" type="text" name="name" size="21" /> </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Password</td>
                                <td align="left">
                                    <input id="pass" name="pass" type="password" size="11" /></td>
                                <td>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td><input id="submit" type="submit" value="Create" name="input" onclick="return ValidCreate()"/></td>
                            </tr>
                        </table>
                    </form>

                </section>

            </div>
        </div>

    </body>
</html>
