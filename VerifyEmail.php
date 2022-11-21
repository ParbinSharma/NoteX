<?php
require("Db_connect.php");
session_start();
$Username=$_SESSION["username"];
$otp=$_SESSION["OTP"];
$email=$_SESSION["Email"];
$password=$_SESSION["Password"];
$wrong=false;
  // Sql query to be executed

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $input1 = $_POST["input1"];
  $input2 = $_POST["input2"];
  $input3 = $_POST["input3"];
  $input4 = $_POST["input4"];
  $input5 = $_POST["input5"];
  $input6 = $_POST["input6"];
  $prime=$input1.$input2.$input3.$input4.$input5.$input6;
  $check2= strval($prime);
if ($check2==$otp) {

  $sql = "INSERT INTO `Passwords` (`Username`, `Password`,`Email`) VALUES ('$Username', '$password','$email')";
  $result = mysqli_query($conn, $sql);
$sql2 = "CREATE TABLE `$Username` (`Serial no.` INT NOT NULL AUTO_INCREMENT , `Title` VARCHAR(50) NOT NULL , `Description` TEXT NOT NULL , PRIMARY KEY (`Serial no.`)) ENGINE = InnoDB;";
  $result2 = mysqli_query($conn, $sql2);
  if($result2&&$result){ 
      $success= true;
     
      header("Location:Login.php");
  }
  else{       $warning=true;

  }
 }
else{
  $wrong=true;
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email • NoteX</title>
<link rel="stylesheet" href="Style.css?v=<?php echo time(); ?>">
 
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
if ($wrong==true) {
 echo "      <div class='center'>
              <div class='alert' style='background-color:yellow;' id='alert'>
        <strong>Warning!</strong>&nbsp;Wrong otp.

      </div>
      </div>";
} 

?>
      <div class="center">
        <img class="otpi" src="otp.png" alt="lady"/>
      </div>
            <h2>Email Verification</h2>
      <p class="msg">Please enter the otp send to <?php echo $email; ?></p>
      <form action="VerifyEmail.php" class="form" method="post">
        <div class=" box">
      <input type="text" class="otp" name="input1" id="input1" maxlength="1" autocomplete="off" required pattern="\d{1}" autofocus>
    <input type="text" class="otp" name="input2" id="input2" maxlength="1" autocomplete="off" required pattern="\d{1}">
    <input type="text" class="otp" name="input3" id="input3" maxlength="1" autocomplete="off" required pattern="\d{1}">
    <input type="text" class="otp" name="input4" id="input4" maxlength="1" autocomplete="off" required pattern="\d{1}">
    <input type="text" class="otp" name="input5" id="input5" maxlength="1" autocomplete="off" required pattern="\d{1}">
    <input type="text" class="otp" name="input6" id="input6" maxlength="1" autocomplete="off" required pattern="\d{1}">
 
        </div>

      <div class="center">
      <button type="submit" class="btn">Submit</button>
      </div>
      </form>
      <script>
      // DOM utility functions:

const els = (sel, par) => (par || document).querySelectorAll(sel);


// Task: multiple inputs "field"

els(".box").forEach((elGroup) => {

  const elsInput = [...elGroup.children];
  const len = elsInput.length;
  
  const handlePaste = (ev) => {
    const clip = ev.clipboardData.getData('text');     // Get clipboard data
    const pin = clip.replace(/\s/g, "");               // Sanitize string
    const ch = [...pin];                               // Create array of chars
    elsInput.forEach((el, i) => el.value = ch[i]??""); // Populate inputs
    elsInput[pin.length - 1].focus();                  // Focus input
  };

  const handleInput = (ev) => {
    const elInp = ev.currentTarget;
    const i = elsInput.indexOf(elInp);
    if (elInp.value && (i+1) % len) elsInput[i + 1].focus();  // focus next
  };
  
  const handleKeyDn = (ev) => {
    const elInp = ev.currentTarget
    const i = elsInput.indexOf(elInp);
    if (!elInp.value && ev.key === "Backspace" && i) elsInput[i - 1].focus(); // Focus previous
  };
  
  
  // Add the same events to every input in group:
  elsInput.forEach(elInp => {
    elInp.addEventListener("paste", handlePaste);   // Handle pasting
    elInp.addEventListener("input", handleInput);   // Handle typing
    elInp.addEventListener("keydown", handleKeyDn); // Handle deleting
  });
  
});


      </script>
      </body>
  </html>