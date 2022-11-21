<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "phpmailer/src/Exception.php";
require "phpmailer/src/PHPMailer.php";
require "phpmailer/src/SMTP.php";
$passwordum=false;
$warning=false;
$success=false;
$exists=false;
$weak=false;

require("Db_connect.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $email = $_POST["email"];
    $hashed_password= password_hash($password,PASSWORD_DEFAULT);
    
    
    
    $uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);
$sql="SELECT `Username` FROM `Passwords` WHERE Username='$username'";
 $check_user = mysqli_query($conn,$sql);
 //echo mysqli_num_rows($check_user);
if(mysqli_num_rows($check_user) > 0){
    $exists=true;
    $warning=false;
}
else{
    if($password==$password2){
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
      $weak=true;
    }
    else{

$mail= new PHPMailer(true);
$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true;
$mail->Username='system.notex@gmail.com';
$mail->Password='qbbadaqgnawnyjkf';
$mail->SMTPSecure='ssl';
$mail->Port=465;
$mail->setFrom('system.notex@gmail.com');
$mail->addAddress($email);
$mail->isHTML(true);
$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);
// Generating otp with php rand variable
$otp=rand(100000,999999);
$message=strval($otp);
$mail->Subject="NoteX";
$mail->Body="Hi ".$username."<br>Your otp is:".$otp."<br>Thank you for using our service. We hope you found it useful.<br>If you had technical issues and could not use our service please reply to this email and tell us what the problem was and we will endeavour to help.<br>Many thanks<br>NoteX";

 if($mail->send()){
   $username = $_POST["username"];
    $password = $_POST["password"];
    
    $email = $_POST["email"];
$_SESSION["username"]=$username;
$_SESSION["OTP"]=$message;
$_SESSION["Email"]=$email;
$_SESSION["Password"]=$hashed_password;
$_SESSION["registration-going-on"]="1";

 header("Location:VerifyEmail.php");

 }
 else{
   $warning=true;
 }
    }
    
    
    }
    else{
     $passwordum=true;
    }
 }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up • NoteX</title>
    <link rel="stylesheet" href="Style.css" type="text/css" media="all" />
<link rel="icon"  href="favicon.png">
  </head>
  <body>
    <nav>
      <div class="label">
        <img alt="logo" src="logo.png" class="logo"/>
      </div>
      <div class="menu">
      
          <li class="option"><a href="index.html">Home</a></li>
          <li class="option"><a href="Login.php">Login</a></li>

       
      </div>
      </nav>
            <?php 
      if($warning==true){
      echo "      <div class='center'>
              <div class='alert'  id='alert'>
        <strong>Warning!</strong>&nbsp;Something went wrong.

      </div>
      </div>";
      }
      if($passwordum==true){
      echo "      <div class='center'>
              <div class='alert' id='alert'>
        <strong>Warning!</strong>&nbsp;Passwords do not match.

      </div>
      </div>";
      }
      if($weak==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:yellow;' id='alert_late'>
        <strong>Warning!</strong>&nbsp;Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.

      </div>
      </div>";
      }
      if($success==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:green;' id='alert'>
        <strong>Success!</strong>&nbsp; Account Created.

      </div>
      </div>";
      }
      if($exists==true){
      echo "      <div class='center'>
              <div class='alert' style='background-color:yellow;' id='alert'>
        <strong>Warning!</strong>&nbsp;Username already exists.

      </div>
      </div>";
      }
      ?>
      <div class="mb-5">
      <h2>Create account</h2>
            <p class="msg">Please fill the input below here </p>
<div  class="container my-4">
  <form action="Signup.php" method="post">
  
  <div class="mb-3">
    <label for="username" class="form-label">Username</label></label>
    <input type="text" class="inputl" id="username" name="username" aria-describedby="emailHelp" autocomplete="off" required>

  </div>
      <div class="mb-3">
    <label for="email" class="form-label">Email</label></label>
    <input type="email" class="inputl" id="email" name="email" aria-describedby="emailHelp" autocomplete="off" required>

  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="inputl" id="password" name="password" required>
  </div>
  
  <div class="mb-3">
    <label for="password2" class="form-label">Password again</label>
    <input type="password" class="inputl" id="password2" name="password2" required>
  </div>
<div class="center">
  <button type="submit" class="btn btn-primary">Sign up</button>
</div>
<div style="text-align:center;" >
  <p class="msg f">Already have a account?<a href="Login.php">Log in</a></p>
</div>
</form>
</div>

  </body>
  <script>
  setTimeout(() => {
  const box = document.getElementById('alert');

  // 👇️ removes element from DOM
  box.style.display = 'none';

  // 👇️ hides element (still takes up space on page)
  // box.style.visibility = 'hidden';
}, 2000); // 👈️ time in milliseconds
  setTimeout(() => {
  const box = document.getElementById('alert_late');

  // 👇️ removes element from DOM
  box.style.display = 'none';

  // 👇️ hides element (still takes up space on page)
  // box.style.visibility = 'hidden';
}, 5000); // 👈️ time in milliseconds
  </script>
</html>