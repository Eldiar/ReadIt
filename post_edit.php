<?php

// Retrieving post information from POST
$postId = $_POST['Id'];

$postMessage = $_POST['postMessage'];

$_SESSION['postMessage'] = $postMessage;

// Post message length check
if (strlen($postMessage) > 4000) {
  $_SESSION['message'] = "The post content cannot be longer than 4000 characters! (including spaces)";
  $_SESSION['ErrorType'] = "postCreation";

  header("location: error.php");
}else {
  // Retrieving User Id from Session
  $userId = $_SESSION['userId'];

  // Instert Post Data into database
  $stmt = $db->prepare("UPDATE Post SET Message=:postMessage WHERE Id=$postId");

  if($stmt->execute(array(':postMessage'=> $postMessage))){

    header("location: viewpost.php?Id=" . $postId . " ");
  }

  else {
    $_SESSION['message'] = 'Something went wrong! Failed to update post.';
    $_SESSION['ErrorType'] = "postCreation";
    header("location: error.php");
  }
}





?>
