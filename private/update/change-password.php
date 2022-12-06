<?php 

// Includes
include "../../app/classes/databaseClass.php";
include "../../app/classes/loginClass.php"; 
include "../../app/classes/verificationClass.php"; 

// Declared Variables
$error = "";
$password = "";
$email = '';
$validationError = '';
$isValid = true;
$verificationKey = '';

// Getting user email
if(isset($_GET['email'])){
    $email = $_GET['email'];
}else{
    $email = '';
}

if(isset($_GET['k'])){
    $myKey = $_GET['k'];
}else{
    $myKey = '';
}

// Checking if the user email is verified or not
if(isset($_GET['email'])){
  $checkValidation = new Verification();
  
  $result = $checkValidation->isValid($email);
  if($result == 0){
    $isValid = false;
    header("Location: ../login");

  }else if($result == 1){
    $isValid = true;
  }else{
    $isValid = "No user registered with that email.";
  }
}

if(isset($_GET['k'])){

    $checkKey = new Verification();

    $result1 = $checkKey->isKey($email, $myKey);
    if($result1 == 1){
        $isValid = true;
        
    }else if($result1 == 2){
        $isValid = false;
        header("Location: ../../login");

    }else{
        $isValid = "Something went wrong.";
    }
}

if(!isset($_GET['k']) || !isset($_GET['email'])){
    $isValid = false;
}

if($isValid == false){
    header("Location: ../../login");
}

$login = new Login();

if(isset($_POST['change'])){

    // Getting informations from the form
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['Cpassword']);

    // Checking the felids
    if(empty($password) && empty($confirm_password)){
        $error .= "Please make sure to fill in all the boxes <br>";

    }else if(strlen($password) < 8){
        $error .= "Password must be at least 8 characters long <br>";

    }else if(empty($password) || empty($confirm_password)){
        $error .= "Please enter a password <br>";

    }else if($password != $confirm_password){
        $error .= "Password doesn't match the confirmed password <br>";

    }else if($error == ""){

        $password = hash("sha1", $password);

        $result = $login->updatePassword($email, $password);
        if($result == 1){
            
            $path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] ."/welfare/login";

            $to = $email;
            $verification_link = "<a href='$path'>Welfare login page</a>";
            $subject = "Your password has been changed.";
            $message = "
                Hello $email

                You have changed your password<br>

                Please go ahead and try to login again with your new password at the following page.<br>
                
                <b>$verification_link</b>
                <br>

                See you there!<br><br>

                <strong>Best regards, the <u>Welfare</u> team.</strong>
            ";

            $headers = "From: aismaili690@gmail.com \r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);

            echo "<script>alert('Your password has been reset. Try to login again!')</script>";
            echo "<script>window.open('../../login','_self')</script>";
        }

        if($result == 2){
            echo "<script>alert('Something went wrong!')</script>";
        }
        
    }
    
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

                <label class="form-control fw-bold">New password :</label>
                <input type="password" name="password" id="password" class="form-control" value="" placeholder="Enter new password"><i class="far fa-eye" id="togglePassword" style="cursor: pointer; font-size: 13px;"> Show password</i>

                <label class="form-control fw-bold">confirm password :</label>
                <input type="password" name="Cpassword" id="Cpassword" value="" class="form-control" placeholder="Confirm password"><i class="far fa-eye" id="toggleCPassword" style="cursor: pointer; font-size: 13px;"> Show password</i>
                  <br>
                    <button type="submit" name="change" class="btn btn-primary">Update password</button>
                      
            </form>
            

        </div>

        <div class="col-lg-5 mt-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">

        <h3 class="section-title">Hello and welcome, one more tap to go!</h3>

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

            if($isValid == false){
              echo "<form action='' method='post'>
              <button type='submit' id='resendVerificationCode' name='resend-verification-code'>Resend verification link</button> 
            </form>";
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