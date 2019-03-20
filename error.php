<?php
/*Displays all error messages*/
session_start();
?>

<html>
<head>
  <title>Error</title>
</head>

<body>

  <div>
    <h1>Error</h1>
    <p>
      <?php
        if( isset($_SESSION['message']) AND !empty($_SESSION['message'])){
            echo $_SESSION['message'];
        }
        else{
          header("location: index.php");
        }
      ?>
    </p>
    <?php
    if( isset($_SESSION['ErrorType']) AND !empty($_SESSION['ErrorType']) ){
      if($_SESSION['ErrorType'] == "login"){
        echo '<a href="login_form.php"><button class="">Back to login!</button></a>';
      }
      if($_SESSION['ErrorType'] == "register"){
        echo '<a href="register_form.php"><button class="">Back to register!</button></a>';
      }
    }
    else{
      header("location: index.php");
    }
    ?>
  </div>
</body>
</html>
