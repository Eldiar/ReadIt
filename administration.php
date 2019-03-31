<?php
require 'db.php';
session_start();


$task = $_POST['action'];
$userId = $_POST['Id'];
$forumId = $_POST['Id'];

// Check if a user Id has been entered, if it hasnt, return to administration_user

// On "deleting" a user, all data remains stored, password is set to normal text instead of a hash which makes the account inaccessable
elseif ($task == "delete"){

  //Sets the password for deleted users to Grasmaaier123
  $stmt = $db->prepare("UPDATE User set Password=:deletedPass WHERE Id=:userId");
  $stmt->execute(array(':deletedPass'=> 'Grasmaaier123', ':userId' => $userId));

  header("location: administration_user.php");
}

// Promoting user to Administrator
elseif ($task == "promote"){
  $stmt = $db->prepare("UPDATE User set Rank=1 WHERE Id=:userId");
  $stmt->execute(array(':userId' => $userId));

  header("location: administration_user.php");
}
// Heading to users profile (to delete specific messages)
elseif ($task == "profile") {
  header("location: profile.php?Id=" . $userId);
}
elseif ($task == "deleteForum") {

  //Get amount of posts on a forum
 $stmt = $db->prepare("SELECT COUNT(PostId) AS amount FROM Forum WHERE ForumId = :forumId");
 $stmt->execute(array(':forumId' => $forumId));

 $amount = $stmt->fetch(PDO::FETCH_ASSOC);
 $amountOfPosts = $amount['amount'];

 for($i=0;$i<$amountOfPosts;$i++){

   $stmt = $db->prepare("SELECT PostId FROM Forum WHERE ForumId = :forumI LIMIT 1");
   $stmt->execute(array('forumId' => $forumId));
   $post = $stmt->fetch(PDO::FETCH_ASSOC);

   $postId = $post['PostId'];

   $delete = $db->prepare("DELETE * FROM `Likes` WHERE PostId = :postId");
   $delete->execute(array(':postId' => $postId));

   $delete = $db->prepare("DELETE * FROM `Comment` WHERE PostId = :postId");
   $delete->execute(array(':postId' => $postId));

   $delete = $db->prepare("DELETE * FROM `Post` WHERE Id = :postId");
   $delete->execute(array(':postId' => $postId));
 }

 $delete = $db->prepare("DELETE * FROM 'Volgen' WHERE ForumId = :forumId");
 $delete->execute(array(':forumId' => $forumId));

 $delete = $db->prepare("DELETE * FROM 'Forum' WHERE ForumId = :forumId");
 $delete->execute(array(':forumId' => $forumId));

 header("location: administration_forums.php");

  //







}

else {
  $_SESSION['message'] = "not a valid task!";
  $_SESSION['ErrorType'] = "Administration";

  header("location: error.php");
}
?>
