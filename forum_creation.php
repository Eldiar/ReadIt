<?php

// Retrieving post information from POST
$forumTitle = $_POST['forumTitle'];
$forumDescription = $_POST['forumDescription'];

$_SESSION['forumTitle'] = $forumTitle;
$_SESSION['forumDescription'] = $forumDescription;
// Checking if the entered variables meet the requirements

$titleLength = strlen($forumTitle);


// Post title length check
if ($titleLength > 100) {
  $_SESSION['message'] = "The title cannot be longer than 100 characters! (including spaces)";
  $_SESSION['ErrorType'] = "forumCreation";

  header("location: error.php");
}
// Post message length check
elseif (strlen($forumDescription) > 2000) {
  $_SESSION['message'] = "The forum description cannot be longer than 4000 characters! (including spaces)";
  $_SESSION['ErrorType'] = "forumCreation";

  header("location: error.php");
}
else {
  // Retrieving User Id from Session
  $userId = $_SESSION['userId'];

  $forumcreatedcheck = $db->prepare("SELECT * FROM Forum WHERE Forum.userId=$userId");
  $forumcreatedcheck->execute();
  $forumcreated = $forumcreatedcheck->fetch(PDO::FETCH_ASSOC);

  $stmt = $db->prepare("SELECT User.Rank AS Ranking FROM User WHERE User.Id = :userId");
  $stmt->execute(array(':userId' => $userId));
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result['Ranking'] == 1) {
    $forumcreated = NULL;
  }
  if (empty($forumcreated)) {

    $stmt = $db->prepare("INSERT INTO Forum (Title, Description, UserId)" .
    "VALUES (:forumTitle, :forumDescription, :UserId)");
    if($stmt->execute(array(':forumTitle' => $forumTitle, ':forumDescription'=> $forumDescription, ':UserId'=>$userId ))){

      //Get post ID of the post that was just created
      $stmt = $db->prepare("SELECT Forum.Id FROM Forum WHERE Forum.UserId = :userId ORDER BY Forum.Id DESC LIMIT 1");
      $stmt->execute(array(':userId' => $userId));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      header("location: forum.php?Id=" . $result['Id'] . " ");
    }else {
      $_SESSION['message'] = 'Something went wrong! Failed to submit forum.';
      $_SESSION['ErrorType'] = "forumCreation";
      header("location: error.php");
    }

  }else {
    $_SESSION['message'] = 'Only one forum per user!';
    $_SESSION['ErrorType'] = "forumCreation";
    header("location: error.php");
  }

}





?>
