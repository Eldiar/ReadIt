<?php

// Retrieving post information from POST
$postTitle = $_POST['postTitle'];
$postMessage = $_POST['postMessage'];
$postForum = $_POST['postForum'];

$_SESSION['postTitle'] = $postTitle;
$_SESSION['postMessage'] = $postMessage;
$_SESSION['postForum'] = $postForum;
// Checking if the entered variables meet the requirements

$titleLength = strlen($postTitle);


// Post title length check
if ($titleLength > 40) {
  $_SESSION['message'] = "The title cannot be longer than 40 characters! (including spaces)";
  $_SESSION['ErrorType'] = "postCreation";

  header("location: error.php");
}
// Post message length check
elseif (strlen($postMessage) > 5000) {
  $_SESSION['message'] = "The post content cannot be longer than 5000 characters! (including spaces)";
  $_SESSION['ErrorType'] = "postCreation";

  header("location: error.php");
}
elseif ($postForum == 0) {
  $_SESSION['message'] = "You must select a forum to post to!";
  $_SESSION['ErrorType'] = "postCreation";

  header("location: error.php");
}
else {
  // Retrieving User Id from Session
  $userId = $_SESSION['userId'];

  // Instert Post Data into database
  $stmt = $db->prepare("INSERT INTO Post (Title, Message, ForumId, UserId)" .
  "VALUES (:postTitle, :postMessage, :postForum, :UserId)");

  if($stmt->execute(array(':postTitle' => $postTitle, ':postMessage'=> $postMessage, ':postForum'=>$postForum, ':UserId'=>$userId ))){

    //Get post ID of the post that was just created
    $stmt = $db->prepare("SELECT Post.Id FROM Post WHERE Post.UserId = :userId ORDER BY Post.Datum DESC LIMIT 1");
    $stmt->execute(array(':userId' => $userId));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    header("location: viewpost.php?Id=" . $result['Id'] . " ");
  }

  else {
    $_SESSION['message'] = 'Something went wrong! Failed to submit post.';
    $_SESSION['ErrorType'] = "postCreation";
    header("location: error.php");
  }
}





?>
