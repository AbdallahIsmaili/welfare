<?php 

// Includes
include "app/classes/databaseClass.php";
include "app/classes/loginClass.php"; 
include "app/classes/verificationClass.php"; 

// Declared Variables
$error = "";
$password = "";
$email = '';
$validationError = '';
$isValid = true;
$verificationKey = '';
$name = '';

// Getting user email
if(isset($_GET['email'])){
    $email = $_GET['email'];
}else{
    $email = '';
}

// Checking if the user email is verified or not
if(isset($_GET['v'])){
  $checkValidation = new Verification();
  
  $result = $checkValidation->isValid($email);
  if($result == 0){
    $isValid = false;
  }else if($result == 1){
    $isValid = true;
  }else{
    $isValid = "No user registered with that email.";
  }
}


// Cookie for remembering password
if (isset($_COOKIE['email']) and isset($_COOKIE['password'])) 
{
  $emailCookie = $_COOKIE['email'];
  $passwordCookie = $_COOKIE['password'];

}else{
  $emailCookie = "";
  $passwordCookie = "";
}

// Log in to your account testing and validation
$login = new Login();

if(isset($_POST['login'])){

    // Getting information from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Checking the felids
    if(empty($email) && empty($name) && empty($password) && empty($confirm_password)){
        $error .= "Please make sure to fill in all the boxes <br>";

    }else if(empty($email) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)){
        $error .= "Please enter a valid email address <br>";

    }else if(strlen($password) < 8){
        $error .= "Password must be at least 8 characters long <br>";

    }else if(empty($password)){
        $error .= "Please enter a password <br>";

    }else if($error == ""){
      
      // Setting up the cookies
        if(isset($_POST['remember']) and $_POST['remember'] == 'on'){
          setcookie('email', $email, time() + (86400 * 30), "/", $domain = "", $secure = false, $httponly = false );
          setcookie('password', $password, time() + (86400 * 30), "/", $domain = "", $secure = false, $httponly = false );
        }

        $password = hash("sha1", $password);

        $result = $login->loginUser($email, $password);
        if($result == 1){
            
            echo "<script>window.open('home','_self')</script>";
        }

        if($result == 2){
          $error .= "Wrong Password <br>";
        }

        if($result == 3){
            
          $validationError .= "No user found with that email. Want to create an account with that email? <a href='register?email=$email'> [ Yes use it ] </a> <br>";
            
        }

        if($result == 4){
            $isValid = false;
            $validationError .= "Please make sure your email is verified! <br>";
        }
        
    }
    
}

// Messaging you if your account is not verified
if($isValid == false){
    $validationError = 'We just sent a verification link to your email address <u>'. $email .'</u>, Please verify your email address before you can access your account.';
}


// Resend new verification link
$Verification = new Verification();

if(isset($_POST['resend-verification-code'])){

  $verificationKey = md5(time(). $email);

  $result = $Verification->updateVerificationCode($verificationKey, $email);

  if($result == 1){
    $path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] ."/welfare/private/validation/verifying?k=$verificationKey";

    $to = $email;
    $verification_link = "<a href='$path'>Your account verification link</a>";
    $subject = "Your email verification.";
    $message = "
        
        Hello $name <br>

        Are you ready to gain access to all of the assets we prepared for Welfare users?<br>

        First, you must complete your registration by clicking on the link below:<br><br>

        $verification_link
        <br><br>

        This link will verify your email address, and then you’ll officially be a part of our community.<br>

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

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Logis Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="public/assets/img/favicon.png" rel="icon">
  <link href="public/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="public/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="public/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="public/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="public/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="public/assets/css/main.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="public/assets/img/logo.png" alt=""> -->
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
          <li><a class="get-a-quote" href="register">New user? sign up</a></li>
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

          <form action="" method="POST" class="" data-aos="fade-up" data-aos-delay="200">

            <input type="text" value="<?=$email?>" name="email" class="form-control" placeholder="Your email address">
            <br>
            <input type="password" name="password" class="form-control" placeholder="Your password">
            <br>

            <button type="submit" name="login" class="btn btn-primary">Login</button>
          </form>

        </div>

        <div class="col-lg-5 mt-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <p class='mt-5' data-aos="fade-up" data-aos-delay="100">Facere distinctio molestiae nisi fugit tenetur repellat non praesentium nesciunt optio quis sit odio nemo quisquam. eius quos reiciendis eum vel eum voluptatem eum maiores eaque id optio ullam occaecati odio est possimus vel reprehenderit</p>

              <?php

                if($isValid == false){
                  echo "<form action='' method='post'>
                  <button class='btn btn-warning' type='submit' id='resendVerificationCode' name='resend-verification-code'>Resend verification link</button> 
                </form>";
                }

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

            <p><a href="private/update/restore-password.php">forgot you password?</a></p>
            
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
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="public/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="public/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="public/assets/vendor/aos/aos.js"></script>
  <script src="public/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="public/assets/js/main.js"></script>

</body>

</html>