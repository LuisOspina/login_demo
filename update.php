<!-- uncomment lines 18 in profile.php and
    the two blocks of code in process.php if you wish you add 
    update user functionality-->
<?php
session_start();
$username = $_SESSION['username'];
include_once("config.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Update</title>
    </head>
    <body>
        <div>
            <h1>Update</h1>
        </div>
        <div>
            <form method="post" action="process.php">
                <input type="text" name="username" placeholder="Username...">
                <input type="text" name="email" placeholder="Email...">
                <input type="password" name="password" placeholder="Password...">
                <input type="text" name="sensitivedata" placeholder="Sensitive Data...">
                <input type="submit" value="Update" name="update">
            </form>
        </div>
    </body>
</html>
