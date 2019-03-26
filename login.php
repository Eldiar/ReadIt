<?php
// User login process, checks if user exists and password is imagegammacorrect

// Get
$username =$_POST['username'];

$stmt = $db->prepare("SELECT * FROM User WHERE User.Username= :username");
$stmt->execute(array(':username' => $username));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$result){ //User doesn't exist
  $_SESSION['message'] = "User with that username doesn't exist!";
  $_SESSION['ErrorType'] = "login";
  header("location: error.php");
}

else{ //user exists

  $user = $result;

  if (password_verify($_POST['password'], $user['Password'])) {

    $_SESSION['username'] = $user['Username'];
    $_SESSION['first_name'] = $user['Firstname'];
    $_SESSION['last_name'] = $user['Lastname'];
    $_SESSION['email'] = $user['Email'];
    $_SESSION['userId'] = $user['Id'];
    $_SESSION['rank'] = $user['Rank'];

    //This is how we know the user is logged in
    $_SESSION['logged_in'] = true;

    header("location: profile.php");
  }

  else {

    $_SESSION['message'] = "You have entered the wrong password, try again!";
    $_SESSION['ErrorType'] = "login";
    header("location: error.php");

  }

}


?>
