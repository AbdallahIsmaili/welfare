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
      header("Location: ../../login");
      
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
    header("Location: ../../login?email=$email&v=false");
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
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Welfare - reset password</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../public/assets/img/favicon.png" rel="icon">
  <link href="../../public/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../public/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../../public/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../public/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="../../public/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../public/assets/css/main.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="../../public/assets/img/logo.png" alt=""> -->
        <h1>Logis</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.html" class="active">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="pricing.html">Pricing</a></li>
          <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact</a></li>
          <li><a class="get-a-quote" href="restore-password.php">Back</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">
    <div class="container">
      <div class="row gy-4 d-flex justify-content-between">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">

          <h2 data-aos="fade-up">Your Lightning Fast Delivery Partner</h2>

          <form action="" method="POST">

          <?php
                if(isset($_GET['s']) && $_GET['s'] == 'true' && $_GET['v'] == 't'){
                  echo "
                  <label class='form-control fw-bolder'>Enter the key we just sent to your email:</label>
                  <input type='number' name='keyNumber' class='form-control' value='' placeholder='Enter your code'>";

                  echo "<br>";

                  echo "
                    <button type='submit' class='btn btn-secondary p-3' id='resendVerificationCode' name='resend-verification-code'>Resend code</button> ";

                }
              ?>

                  <button type='submit' name='verify-key' class='btn btn-primary p-3'>Verifying my key</button>

            </form>
            

        </div>

        <div class="col-lg-5 mt-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">

        <h3 class="section-title">Let's continue our mission!</h3>

        <?php

            if(isset($error) and !empty($error)){
            echo "<div class='bg-danger text-light alert alert-danger alert-icon' role='alert'>
            <i class='mdi mdi-diameter-variant'></i>  $error
            </div>";
            }else{
            echo "";
            }

            if(isset($validationError) and !empty($validationError)){
            echo "<div class='bg-warning text-light alert alert-warning alert-icon' role='alert'>
            <i class='mdi mdi-alert-decagram-outline'></i> $validationError
            </div>";
            }else{
            echo "";
            }

        ?>
            
        </div>

        </div>

      </div>
    </div>
  </section><!-- End Hero Section -->

  
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-info">
          <a href="index.html" class="logo d-flex align-items-center">
            <span>Logis</span>
          </a>
          <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
          <div class="social-links d-flex mt-4">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <p>
            A108 Adam Street <br>
            New York, NY 535022<br>
            United States <br><br>
            <strong>Phone:</strong> +1 5589 55488 55<br>
            <strong>Email:</strong> info@example.com<br>
          </p>

        </div>

      </div>
    </div>

    <div class="container mt-4">
      <div class="copyright">
        &copy; Copyright <strong><span>Logis</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>


  <!-- Vendor JS Files -->
  <script src="../../public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../../public/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../public/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../public/assets/vendor/aos/aos.js"></script>
  <script src="../../public/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../public/assets/js/main.js"></script>

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