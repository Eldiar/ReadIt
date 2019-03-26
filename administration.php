<?php

$task = $_POST['Action'];
$userId = $_GET['Id'];

// Check if a user Id has been entered, if it hasnt, return to administration_user
if (!isset($userId) || empty($userId)){
  header("location: administration_user.php");
}

// Deleting target user account ()
if ($task == "delete"){

}

// Promoting user to Administrator
if ($task == "promote"){
  $stmt =
}
// Heading to users profile (to delete specific messages)
if ($task == "profile") {

}

else {
  $_SESSION['message'] = "not a valid task!";
  $_SESSION['ErrorType'] = "Administration";

  header("location: error.php");
}
?>
