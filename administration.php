<?php
require 'db.php';
session_start();


$task = $_POST['action'];
$userId = $_POST['Id'];

// Check if a user Id has been entered, if it hasnt, return to administration_user
if (!isset($userId) || empty($userId)){
  header("location: administration_user.php");
}

// On "deleting" a user, all data remains stored, password is set to normal text instead of a hash which makes the account inaccessable
elseif ($task == "delete"){

//Sets the password for deleted users to Grasmaaier123
$stmt = $db->prepare("UPDATE User set Password=:deletedPass WHERE Id=:userId");
$stmt->execute(array(':deletedPass'=> 'Grasmaaier123', ':userId' => $userId));

header("location: administration_user.php");
}

// Promoting user to Administrator
elseif ($task == "promote"){
}
// Heading to users profile (to delete specific messages)
elseif ($task == "profile") {

}

else {
  $_SESSION['message'] = "not a valid task!";
  $_SESSION['ErrorType'] = "Administration";

  header("location: error.php");
}
?>
