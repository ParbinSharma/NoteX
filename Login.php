<?php
$warning=false;
$logged=false;
$loggedin=false;
 require("Db_connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $username = $_POST["username"];
    $password = $_POST["password"];

  // Sql query to be executed
      $sql="SELECT `Password` FROM `Passwords` WHERE Username='$username'";
  $result=mysqli_query($conn,$sql);
  
    $row = mysqli_fetch_assoc($result);

   
  if(password_verify($password,$row['Password'])){ 
     
    session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: Main.php");
        $loggedin=true;
  }
  else{
      $logged=true;
  } 
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in • NoteX</title>
    <link rel="stylesheet" href="Style.css" type="text/css"/>
<link rel="icon"  href="favicon.png">
  </head>
  <body>
    <nav>
      <div class="label">
        <img alt="logo" src="logo.png" class="logo"/>
      </div>
      <div class="menu">
      
          <li class="option"><a href="index.html">Home</a></li>
          <li class="option"><a href="Signup.php">Register</a></li>

       
      </div>
      </nav>
      
      <?php 
      if($warning==true){
      echo "      <div class='center'>
              <div class='alert' id='alert'>
        <strong>Warning!</strong>&nbsp;Something went wrong.

      </div>
      </div>";
      }
      if($logged==true){
      echo "      <div class='center'>
              <div class='alert' id='alert'>
        <strong>Warning!</strong>&nbsp;Username or password is incorrect.

      </div>
      </div>";
      }
      if($loggedin==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:green' id='alert'>
        <strong>Success!</strong>&nbsp;You ar logged in.

      </div>
      </div>";
      }


      ?>
      
      <div class="center">
        <img class="lady" src="lady.jpeg" alt="lady"/>
      </div>
      <h2>Login</h2>
      <p class="msg">Please login to continue </p>

  <form action="Login.php" class="form" method="post">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="inputl" id="username" name="username" aria-describedby="emailHelp" autocomplete="off">

  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="inputl" id="password" name="password" autocomplete="off">
  </div>
<div class="center">
  
  <button type="submit" class="btn">Log in</button>
  
</div>
<div style="text-align:center;" >
  <p class="msg f">Don't have a account?<a href="Signup.php">Sign up</a></p>
</div>
</form>


  </body>
<script>

setTimeout(() => {
  const box = document.getElementById('alert');

  // 👇️ removes element from DOM
  box.style.display = 'none';

  // 👇️ hides element (still takes up space on page)
  // box.style.visibility = 'hidden';
}, 2000); // 👈️ time in milliseconds

</script>

</html>