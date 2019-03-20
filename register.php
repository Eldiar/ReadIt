<?php

  //Set session variables for use on profile page
  $_SESSION['username'] = $_POST['username'];
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['first_name'] = $_POST['first_name'];
  $_SESSION['last_name'] = $_POST['last_name'];
  $_SESSION['birthday'] = $_POST['birthday'];

  // Escape all $_POST variables to protect against SQL injections
  $username =$_POST['username'];
  $email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $birthday = $_POST['birthday'];

  // Check if user with that email already exists
  $stmt = $db->prepare("SELECT * FROM User WHERE User.EmailAdress= :email");
  $stmt->execute(array(':email' => $email));
  $result = $stmt->fetchAll();

  //We know user email exists if returned rows > 0
  if ($result->num_rows > 0) {

    $_SESSION['message'] = 'User with this email already exists!';
    $_SESSION['ErrorType'] = "register";
    header("location: error.php");

  }

  else { //email doesnt already exist in the database

    $stmt = $db->prepare("INSERT INTO User (Username, Password, Birthday, Firstname, Lastname, EmailAdress)" .
    "VALUES (:username, :password, :birthday, :firstname, :lastname, :email)");

    if($stmt->execute(array(':username' => $username, ':password'=> $password, ':birthday'=>$birthday, ':firstname'=>$first_name, ':lastname'=>$last_name, ':email'=>$email))){
    $_SESSION['active'] = 1;
    $_SESSION['logged_in'] = true;

    header("location: profile.php");

  }

  else {
    $_SESSION['message'] = 'Registration failed!';
    $_SESSION['ErrorType'] = "register";
    header("location: error.php");
  }

}
?>
