<?php

  //Set session variables for use on profile page
  $_SESSION['username'] = $_POST['username'];
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['first_name'] = $_POST['first_name'];
  $_SESSION['last_name'] = $_POST['last_name'];
  $_SESSION['birthday'] = $_POST['birthday'];

  // Escape all $_POST variables to protect against SQL injections
  $username = $db->escape_string($_POST['username']);
  $email = $db->escape_string($_POST['email']);
  $first_name = $db->escape_string($_POST['first_name']);
  $last_name = $db->escape_string($_POST['last_name']);
  $password = $db->escape_string(password_hash($_POST['username'], PASSWORD_BCRYPT));
  $hash = $db->escape_string(md5(rand(0,1000)));
  $birthday = $_POST['birthday'];

  // Check if user with that email already exists
  $stmt = $db->query("SELECT * FROM User WHERE email='$email'");
  $result = $stmt->fetch();

  //We know user email exists if returned rows > 0
  if ($result->num_rows > 0) {

    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php")

  }

  else { //email doesnt already exist in the database

    $stmt = $db->query("INSERT INTO User (Username, Password, Birthday, Firstname, Lastname, EmailAdress, Hash)" .
    "VALUES ('$username', '$password', '$birthday', '$first_name', '$last_name, $email', '$hash')");

    if($stmt->fetch()){
    $_SESSION['active'] = 0;
    $_SESSION['logged_in'] = true;
    $_SESSION['message'] =

              "Confirmation link has been sent to $email, please verify
              your account by clicking the on the link in the message!";

    //Send registration confirmation link (verify.php)
    $to = $email;
    $subject = 'ReadIt Account Verification';
    $message_body =
    'Hello ' .$first_name . ',

    Thank you for signing up to ReadIt!

    Please click this link to activate your account:

    https://www.sgni.nl/~113924/verify.php?email='.$email.'&hash='.$hash'

    Greetings, the ReadIt team.';

    mail($to, $subject, $message_body);
    header("location: profile.php");

  }

  else {
    $_SESSION['message'] = 'Registration failed!';
    header("location: error.php");
  }

}
?>
