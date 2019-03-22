<?php

  //Set variables for local use
  $username =$_POST['username'];
  $email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $birthday = $_POST['birthday'];

  $usernamelength = strlen($username);
  $emaillength = strlen($email);
  $first_namelength = strlen($first_name);
  $last_namelength = strlen($last_name);
  $passwordlength = strlen($password);

  if ($usernamelength > 16){
    $_SESSION['message'] = 'This username is too long!';
    $_SESSION['ErrorType'] = "register";
    header("location: error.php");
  }
  elseif ($emaillength > 100) {
    $_SESSION['message'] = 'This email is too long!';
    $_SESSION['ErrorType'] = "register";
    header("location: error.php");
  }
  elseif ($first_namelength > 30) {
    $_SESSION['message'] = 'This first name is too long!';
    $_SESSION['ErrorType'] = "register";
    header("location: error.php");
  }
  elseif ($last_namelength > 40) {
    $_SESSION['message'] = 'This last name is too long!';
    $_SESSION['ErrorType'] = "register";
    header("location: error.php");
  }

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
      header("location: login_form.php");
    }

    else {
      $_SESSION['message'] = 'Registration failed!';
      $_SESSION['ErrorType'] = "register";
      header("location: error.php");
    }
  }
?>
