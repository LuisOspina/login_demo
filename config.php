<?php
class config {
    public static function connect(){
        $host = "localhost";
        $username = "root";
        $password = "password";
        $dbname = "login_demo";
        try {
            $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }
        return $con;
    }
}
