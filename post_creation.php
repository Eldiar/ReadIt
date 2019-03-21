<?php

// Retrieving post information from POST
$postTitle = $_POST['postTitle'];
$postMessage = $_POST['postMessage'];
$postForum = $_POST['postForum'];

// Checking if the entered variables meet the requirements

// Post title length check
if (strlen($postTitle) > 40){
  $_POST['message'] = "The title cannot be longer than 40 characters! (including spaces)";
  $_POST['ErrorType'] = "PostCreation";

  header("location: error.php")
}
// Post message length check
if (strlen($postMessage) > 5000){
  $_POST['message'] = "The post content cannot be longer than 5000 characters! (including spaces)";
  $_POST['ErrorType'] = "PostCreation";

  header("location: error.php")
}


// Retrieving User Id from Session
$userId = $_SESSION['userId'];

// Instert Post Data into database
$stmt = $db->prepare("INSERT INTO Post (Title, Message, ForumId, UserId)" .
"VALUES (:postTitle, :postMessage, :postForum :UserId)");

if(!$stmt->execute(array(':postTitle' => $postTitle, ':postMessage'=> $postMessage, ':postForum'=>$postForum, ':UserId'=>$userId ))){

  //Get post ID of the post that was just created

  $stmt = $db->prepare("SELECT Post.Id FROM Post WHERE Post.UserId = $userId ORDER BY Post.Datum"); //Add a limit of 1 to the query
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $_GET['postId'] = $result['Id']


  header("location: profile.php");
}

else {
  $_SESSION['message'] = 'Something went wrong! Failed to submit post.';
  $_SESSION['ErrorType'] = "PostCreation";
  header("location: error.php");
}

// If successful send user to post page




?>
