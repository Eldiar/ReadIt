<?php
// User login process, checks if user exists and password is imagegammacorrect

]// Escape email to protect against SQL injections
$username = $db->escape_string($_POST['username']);

$stmt = $db->query("SELECT * FROM User WHERE Username='$username'");
$result = $stmt->fetch();

if( $result->num_rows == 0){ //User doesn't exist
  $_SESSION['message'] = "User with that username doesn't exist!";
  header("location: error.php");
}

else{ //user exists

  $user = result->fetch_assoc();

  if ( password_verify($_POST['password'], $user['password']) ) {

    $_SESSION['username'] = $user['Username'];
    $_SESSION['first_name'] = $user['Firstname'];
    $_SESSION['last_name'] = $user['Lastname'];
    $_SESSION['email'] = $user['Email'];
    $_SESSION['active'] = $user['Active'];

    //This is how we know the user is logged in
    $_SESSION['logged_in'] = true;

    header("location: profile.php")
  }

  else {
    $_SESSION['message'] = "You have entered the wrong password, try again!"
    $_SESSION['logregError'] == "login";
    header("location: error.php");

  }

}


?>
