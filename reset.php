<?php
// The reset password form (forgot.php) includes the link to this page.

require 'db.php';
session_start();

// Make sure email and hash variables arent EmptyIterator

if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) ){

  $email = $db->escape_string($_GET['email']);
  $hash = $db->escape_string($_GET['hash']);

  //Make sure user email with matching hash exists
  $stmt = $db->query("SELECT * FROM User WHERE Email='$email' AND hash='$hash'");
  $result = $stmt->fetch();

  if ( $result->num_rows == 0){
    $_SESSION['message'] = "You have entered an invalid URL for password reset!"
    $_SESSION['ErrorType'] = "reset";
    header("location: error.php");
  }

else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    $_SESSION['ErrorType'] = "reset";
    header("location: error.php");
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Password Reset</title>
  </head>
  <body>
    <form class="" action="index.html" method="post">
      <label>Fill in your new password below!</label>
      <input type="password" name="newpass"></input>

      <button type="submit" name="reset">Reset now!</button>
    </form>
  </body>
</html>
