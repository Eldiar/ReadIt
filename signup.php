<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadIt - Home</title>

    <!-- CSS Link -->
      <link rel="stylesheet" type="text/css" href="readitstyle.css">
    <!-- PHP Links -->

    <!-- Javascript Links -->

  </head>
  <body>
    <div class="header">

      <div class="logo">
        <img src="Images/logo.png" alt="ReadIt Logo">
        <h3>ReadIt</h3>
      </div>

      <div class="navbar navhover">
        <a href="index.php">Home</a>
        <a href="#">Forums</a>
        <a href="topfeed.php">Top</a>
      </div>

      <div class="accountbar">
        <div class="accountbarplaceholder"></div>
        <div class="dropdown navhover">
          <button class="dropbtn">Account</button>
          <div class="dropdown-content">
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
            <a href="#">Logout</a>
            <a href="profile.php">Profile</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->

    <div class="content">

      <div class="mid">
        <div class="between25"></div>

        <div class="signup">
          <p>Sign up</p>
          <form class="signupform" action="index.html" method="post">
            <label>Username:</label><br/>
            <input type="text" name="username"><br/>

            <label>Email address</label><br/>
            <input type="email" name="emailadress"><br/>

            <label>Password:</label><br/>
            <input type="password" name="password"><br/>

            <label>Confirm password:</label><br/>
            <input type="password" name="confirmpassword"><br/>

            <label>First name</label> <label>Last name</label><br/>
            <input type="text" name="firstname">
            <input type="text" name="lastname"><br/>

            <label>Birthday</label><br/>
            <input type="date" name="birthday"><br/>

            <input type="submit" value="Create account">
          </form>
        </div>

        <div class="between25"></div>
      </div>



  </body>
</html>
