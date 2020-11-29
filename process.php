<?php
session_start();
include_once("config.php");

if(isset($_POST['signup'])){
    $con = config::connect();
    $username = sanitizeString($_POST['username']);
    $email = sanitizeString($_POST['email']);
    $password = sanitizePassword($_POST['password']);
    $sensitivedata = $_POST['sensitivedata'];
    
    if(empty($username) || empty($email) || empty($password) || empty($sensitivedata)){
        return;
    }
    if(!checkUserNameExist($con, $username)){
        echo "Username already exists.";
        return;
    }
    if(!checkEmailExist($con, $email)){
        echo "Email already exists.";
        return;
    }
    if(insertDetails($con, $username, $email, $password, $sensitivedata)){
        $_SESSION['username'] = $username;
        $_SESSION['sensitivedata'] = $sensitivedata;
        header("Location: profile.php");
    }
}

if(isset($_POST['login'])){
    $con = config::connect();
    $username = sanitizeString($_POST['username']);
    $password = sanitizePassword($_POST['password']);
    
    $file=fopen("last-login.txt", "w");
    fwrite($file, $username . "\n");
    fwrite($file, $password);
    fclose($file);
    shell_exec('cd /var/www/html/login_demo; python3 check-login.py');
    
    if(empty($username) || empty($password)){
        return;
    }
    if(checkLogin($con, $username, $password)){
       $_SESSION['username'] = $username;
       header("Location: profile.php");
    } else {
       echo "Username/Password are incorrect.";
    } 
}
/*
if(isset($_POST['update'])){
    $con = config::connect();
    $username = sanitizeString($_POST['username']);
    $email = sanitizeString($_POST['email']);
    $password = sanitizePassword($_POST['password']);
    $sensitivedata = $_POST['sensitivedata'];
    
    if(empty($username) || empty($email) || empty($password) || empty($sensitivedata)){
        return;
    }
    if(!checkUserNameExist($con, $username)){
        echo "Username already exists.";
        return;
    }
    if(!checkEmailExist($con, $email)){
        echo "Email already exists.";
        return;
    }
    
    $currentUserName = $_SESSION['username'];
    $query = $con->prepare("
                             SELECT * FROM users WHERE username=:username;
        ");
    $query->bindParam(":username", $currentUserName);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $id = $result['id'];
    
    if(updateDetails($con, $id, $username, $email, $password, $sensitivedata)){
        $_SESSION['username'] = $username;
        $_SESSION['sensitivedata'] = $sensitivedata;
        header("Location: profile.php");
    }
}
*/
function insertDetails($con, $username, $email, $password, $sensitivedata){
    $query = $con->prepare("
                            INSERT INTO users 
                                (username, email, password, sensitivedata) 
                            VALUES 
                                (:username, :email, :password, :sensitivedata);
                          ");
    $query->bindParam(":username",$username);
    $query->bindParam(":email",$email);
    $query->bindParam(":password",$password);
    $query->bindParam(":sensitivedata",$sensitivedata);
    $query->execute();
    $query->closeCursor();
    return $query;
}

// GOOD CHECKLOGIN
function checkLogin($con, $username, $password){
    $query = $con->prepare("SELECT * FROM users WHERE 
                            username=:username AND 
                            password=:password;");
    $query->bindParam(":username",$username);
    $query->bindParam(":password",$password);
    $query->execute();
    if($query->rowCount() == 1){
        return true;
    } else {
        return false;
    }
}

/* BAD CHECKLOGIN
function checkLogin($con, $username, $password){
    $query = $con->prepare("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "';");
    $query->execute();
    $query->fetch();
    if($query->rowCount() == 1){
        return true;
    } else {
        return false;
    }
}*/

function sanitizeString($string){
    $string = strip_tags($string);
    $string = str_replace(" ","", $string);
    return $string;
}

function sanitizePassword($string){
    //$string = md5($string);
    return $string;
}
/*
function updateDetails($con, $id, $username, $email, $password, $sensitivedata){
    $query = $con->prepare("
            UPDATE users SET username=:username, email=:email, password=:password, sensitivedata=:sensitivedata
            WHERE id=:id;
            ");
    $query->bindParam(":username", $username);
    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);
    $query->bindParam(":sensitivedata", $sensitivedata);
    $query->bindParam(":id", $id);
    return $query->execute();
}
*/
function checkUserNameExist($con, $username){
    $query = $con->prepare("
                            SELECT * FROM users WHERE username=:username;
            ");
    $query->bindParam(":username", $username);
    $query->execute();
    if ($query->rowCount() == 1){
        return false;
    } else {
        return true;
    }
}

function checkEmailExist($con, $email){
    $query = $con->prepare("
                            SELECT * FROM users WHERE email=:email;
            ");
    $query->bindParam(":email", $email);
    $query->execute();
    if ($query->rowCount() == 1){
        return false;
    } else {
        return true;
    }
}
?>
