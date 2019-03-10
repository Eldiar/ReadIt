<?php
/*Displays all error messages*/
session_start();
?>

<html>
<head>
  <title>Success!</title>
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
  </div>
</body>
</html>
