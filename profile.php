<?php
session_start();
include_once("config.php");
$con=config::connect();
$results=fetchRecords($con);
function fetchRecords($con){
    $query = $con->prepare("
                        SELECT * FROM users WHERE username='{$_SESSION['username']}';
            ");
    $query->execute();
    return $query->fetch();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <img src="kpu-logo-1.png" alt="logo" style="width:50px;height:50px;">
        <h1>Profile</h1>
        Welcome <?php echo $_SESSION['username'];?> <br>
        Your sensitive data: <?php echo $_SESSION['sensitivedata'];?> <br><br>
        <div>
            <a href='logout.php'>Logout</a> &nbsp;
            <!-- <a href='update.php'>Update</a> &nbsp; -->
            <a href='delete.php'>Delete</a>
        </div>
    </body>
</html>
