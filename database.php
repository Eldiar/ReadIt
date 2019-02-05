<?php
$servername = "localhost:3307";
$username = "6in1 René Tielen";
$password = "113924";

try {
   $conn = new PDO("mysql:host=$servername;dbname=6in1 René Tielen", $username, $password);
   // set the PDO error mode to exception
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "Connected successfully";
   }
catch(PDOException $e)
   {
   echo "Connection failed: " . $e->getMessage();
   }
?>
