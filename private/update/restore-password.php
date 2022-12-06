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
$sent = 'false';

if(isset($_GET['email'])){
  $e = $_GET['email'];
}else{
  $e = '';
}

if(isset($_POST['email'])){   
    $email = trim($_POST['email']);

    $checkValidation = new Verification();
  
    $result = $checkValidation->isValid($email);
    if($result == 0){
      $isValid = false;
      $valid = "f";
      header("Location: ../login?email=$email&v=false");

    }else if($result == 1){
      $isValid = true;
      $valid = "t";

    }else{
      $isValid = "No user registered with that email.";
    }

}else{
  $email = '';
  $isValid = false;
}

// Log in to your account testing and validation
$restore = new Login();

if(isset($_POST['Restore'])){

      // Checking the felids
      if(empty($email) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)){
        $error .= "Please enter a valid email address <br>";

      }else if($error == "" && $isValid == true){

          $result = $restore->findUser($email);
          if($result == 1){
              
              // Resend new verification link
              $Verification = new Verification();

              $verificationNumber = rand(100000,1000000);

              $result = $Verification->updateVerificationNumber($verificationNumber, $email);

              if($result == 1){

                $to = $email;
                $verification_link = "<b><u>$verificationNumber</u></b>";
                $subject = "Password restoration key.";
                $message = "
                    
                    Hello $name <br>

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

                $sent = 'true';

                header("Location: verify-key?e=$email&s=$sent&v=$valid");

                $validationError = "We sent a new verification link to your email $email.";

              }else{
                $validationError = "Something went wrong, try again later.";

              }
          }

          if($result == 2){
              $error = "Sorry, we didn't found any account registered with that email. Please make sure to check your email first ten try again.";
          }
          
      }
    
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
            <h3 class="section-title">Let's start our mission!</h3>
            <br>

            <center>

              <p class='validation-error'><?php echo $validationError; ?></p>
              <h4 style="color: red"><?php echo $error; ?></h4>

            </center>
            <br>

            <form action="restore-password.php" method="POST">

              <p class='inputName'>Email :</p>
                  
                  
                  <?php
                    if(isset($_GET['email'])){
                      echo "<input type='email' name='email' class='register_field' value='$e' placeholder='Enter your email' readonly>";
                    }else{
                      echo "<input type='email' name='email' class='register_field' value='$e' placeholder='Enter your email'>";
                    }
                  ?>

                <br>
                    <br>
                    

                    <?php
                    if(isset($_GET['email'])){
                      echo "<button type='submit' name='Restore' class='btn btn-primary'>Change my password</button>";
                    }else{
                      echo "<button type='submit' name='Restore' class='btn btn-primary'>Restore my password</button>";
                    }
                  ?>

                    <?php

                      // if(isset($_GET['s']) && isset($_GET['e']) && $_GET['s'] == 'true' && $isValid == true){
                      //   echo "<button type='submit' name='ChangePassword' class='btn btn-primary'>Change my password</button>";

                      // }

                    ?>


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

    
    // function sendAgain() {
    //   document.getElementById("resendVerificationCode").disabled = true;
    //   setTimeout(function() {
    //       document.getElementById("resendVerificationCode").disabled = false;
    //   }, 5000);
    // }
    // document.getElementById("resendVerificationCode").addEventListener("click", sendAgain);

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