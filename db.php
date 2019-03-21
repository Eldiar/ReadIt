<?php
$host = "localhost:3307";
$username = "6in1 René Tielen";
$password = "113924";
$dbname = "6in1 René Tielen";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>
