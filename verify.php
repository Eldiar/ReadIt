<?php
/*Verifies registered user email, the link to this page
  is included in the register.php email message.
*/

require 'db.php';
session_start();

// Make sure email and hash variables aren't empty
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['email'])){

  $email = $db->escape_string($_GET['email']);
  $hash = $db->escape_string($_GET['hash']);

  //Select user with matching email and hash, who hasn't verified their account yet (active = 0)
  $stmt = $db->query("SELECT * FROM User WHERE email='$email' AND Hash='$hash' AND Active='0'");
  $result = $stmt->fetch();

    if ( $result->num_rows == 0 ){
      $_SESSION['message'] = "Account has already been activated or the URL is invalid!";
      $_SESSION['ErrorType'] = "verify";
      header("location: error.php");

    }
    else {
      $_SESSION['message'] = "Your account has been activated!";

      // Set the user status to active (active = 1)
      $stmt = $db->query("UPDATE user SET Active='1' WHERE email='$email'");
      $stmt->execute() or die($db->error); // misschien vervangen door $e

      $_SESSION['active'] = 1;

      header("location: success.php")
    }
  else{
    $_SESSION['message'] = "Invalid parameters provided for account verification!";
    $_SESSION['ErrorType'] = "verify";
    header("location: error.php")
  }

}
 ?>
