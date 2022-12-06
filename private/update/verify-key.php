<?php

// Includes
include "../../app/classes/databaseClass.php";
include "../../app/classes/loginClass.php"; 
include "../../app/classes/verificationClass.php"; 

// Declared Variables
$email = '';
$error = "";
$validationError = '';
$isValid = false;
$verificationNumber = '';
$keyNumber = '';

if(isset($_GET['e'])){
    $email = trim($_GET['e']);   
}

if(isset($_GET['s'])){
$send = trim($_GET['s']);   
}

if(isset($_GET['v'])){
    $checkValidation = new Verification();
    $result = $checkValidation->isValid($email);
    if($result == 0){
      $isValid = false;
      header("Location: ../login.php");
      
    }else if($result == 1){
      $isValid = true;
    }else{
      $isValid = "No user registered with that email.";
    }
}

// Resend verification key to restore password
$Verification = new Verification();

if(isset($_POST['resend-verification-code'])){

  $verificationNumber = rand(100000,1000000);

  $result = $Verification->updateVerificationNumber($verificationNumber, $email);

  if($result == 1){

    $to = $email;
    $verification_link = "<b><u>$verificationNumber</u></b>";
    $subject = "Password restoration key.";
    $message = "

        Please enter the following code to complete your verification:<br>

        $verification_link
        <br><br>

        After you enter that code you'll be able to change your password.<br>

        See you there!<br><br>

        <strong>Best regards, the <u>Welfare</u> team.</strong>
    ";

    $headers = "From: aismaili690@gmail.com \r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);

    $validationError = "We sent a new verification link to your email $email.";

  }else{
    $validationError = "Something went wrong, try again later.";

  }
  
  if($result == 2){
    $error = "Sorry, we didn't found any account registered with that email. Please make sure to check your email first ten try again.";
  }
}

// Messaging you if your account is not verified
if($isValid == false || $_GET['v'] == 'f'){
    $validationError = 'This email is not verified yet, please verify your account first. Check the link we already sent to your email address or go back to login page for a resend.';
    header("Location: ../login?email=$email&v=false");
}


//Verifying change password key
$VerifyKey = new Verification();

if(isset($_POST['keyNumber'])){
  $keyNumber = trim($_POST['keyNumber']);
}

if(isset($_POST['verify-key'])){

  $result = $VerifyKey->checkKeyValidation($email, $keyNumber);

  if($result == 1){
    header("Location: change-password?email=$email&k=$keyNumber");

  }
  
  if($result == 2){
    $error = "Please make sure to enter the number we sent to your email";

  };

  if($result == 3){
    $error = "Something went wrong. Please try again later";

  };

}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welfare - Restore password</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="../app/theme/assets/css/style.css?v1.10.2">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

  <!-- 
    - #HEADER
  -->


  <div class="container">
        
        <br>
        <section class="login-form">
            <h3 class="section-title">Let's continue our mission!</h3>
            <br>

            <center>

              <p class='validation-error'><?php echo $validationError; ?></p>
              <h4 style="color: red"><?php echo $error; ?></h4>

            </center>
            <br>

            <form action="" method="POST">

              <?php
                if(isset($_GET['s']) && $_GET['s'] == 'true' && $_GET['v'] == 't'){
                  echo "
                  <p class='inputName'>Enter the key we just sent to your email:</p>
                  <input type='number' name='keyNumber' class='register_field' value='' placeholder='Enter your code'>";

                  echo "<br>";

                  echo "
                    <button type='submit' id='resendVerificationCode' name='resend-verification-code'>Resend verification code</button> ";

                }
              ?>

                <br>
                    <br>

                  <button type='submit' name='verify-key' class='btn btn-primary'>Verifying my key</button>

            </form>
            <br>
            <br>
            
            <p>Don't have an account? <a href="register.php">Register now!</a></p>

        </section>

    </div>

    <br>
    <br>

  
  <!-- 
    - #FOOTER
  -->


  <!-- 
    - custom js link
  -->
  <script src="../app/theme/assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const toggleCPassword = document.querySelector('#toggleCPassword');
    const password = document.querySelector('#password');
    const Cpassword = document.querySelector('#Cpassword');

    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
    });

    toggleCPassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = Cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
        Cpassword.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

  </script>

</body>

</html>