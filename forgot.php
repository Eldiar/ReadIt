<?php
// Reset your password form, sends reset.php password mysqli_get_links_stats

// Check if form submitted with method="post"

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  $email = $db->escape_string($_POST['email']);

  $stmt = $db->query("SELECT * FROM User WHERE email='$email'");
  $result = $stmt->fetch();

  if ( $result->num_rows == 0){ //User doesn't exists
    $_SESSION['message'] = "User with that email doesn't exist!";
    $_SESSION['ErrorType'] = "forgot";
    header(location: error.php);
  }

  else{ // User exists (num_rows != 0)

    $user = $result->fetch_assoc();

    $email = $user['Email'];
    $hash = $user['Hash'];
    $first_name = $user['Firstname'];

    // Session message to display on success.php
    $_SESSION['message'] = "<p>
    Please check your email <span>$email</span> for a confirmation link to complete your password reset!</p>";

    //Send registration confirmation link (reset.php)
    $to = $email;
    $subject = 'ReadIt Password Reset'
    $message_body = '
    Hello ' .$first_name. ',

    You have requested a password reset!

    Please click this link to reset your password:

    https://www.sgni.nl/~113924/reset.php?email='.$email.'&hash='.$hash;

    header("location: success.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Forgot password</title>
  </head>
  <body>
    <form class="" action="index.html" method="post">
      <label>Fill in your email adress below:</label><br/>
      <input type="email" name="email"><br/>

      <button type="submit" name="forgot">Click here!</button>
    </form>
  </body>
</html>
