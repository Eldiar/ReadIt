<?php

  //Set session variables for use on profile page
  $_SESSION['username'] = $_POST['username'];
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['first_name'] = $_POST['first_name'];
  $_SESSION['last_name'] = $_POST['last_name'];
  $_SESSION['birthday'] = $_POST['birthday'];

  //Set variables for local use
  $username =$_POST['username'];
  $email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $birthday = $_POST['birthday'];

  // Check if user with that email already exists
  $stmt = $db->prepare("SELECT * FROM User WHERE User.Username= :username");
  $stmt->execute(array(':username' => $username));
  $result = $stmt->fetch();

  //We know user email exists if returned $result is set
  if ($result) {

    $_SESSION['message'] = 'This username has already been taken!';
    $_SESSION['ErrorType'] = "register";
    header("location: error.php");

  }

  else { //email doesnt already exist in the database

    $stmt = $db->prepare("INSERT INTO User (Username, Password, Birthday, Firstname, Lastname, EmailAdress)" .
    "VALUES (:username, :password, :birthday, :firstname, :lastname, :email)");

    if($stmt->execute(array(':username' => $username, ':password'=> $password, ':birthday'=>$birthday, ':firstname'=>$first_name, ':lastname'=>$last_name, ':email'=>$email))){
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
