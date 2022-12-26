<?php

include "../../app/classes/databaseClass.php";
include "../../app/classes/profileClass.php"; 

session_start();

if(isset($_SESSION['user_url'])){
    
    $userURL = $_SESSION['user_url'];
    $oldEmail = $_SESSION['user_email'];
    $oldUsername = $_SESSION['user_name'];
    $username = $_SESSION['user_name'];
    $phoneNumber = $_SESSION['user_phone'];
    $userAddress = $_SESSION['user_address'];
    $userCIN = $_SESSION['user_cin'];

  }else{

    $userURL = "";
    $oldEmail = "";
    $oldUsername = "";
    $username = "";
    $phoneNumber = "";
    $userAddress = "";
    $userCIN = "";
  }

$profileUpdate = new Profile();

$error = "";
$validationError = "";

if(isset($_POST['update-info'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['confirmation_password']);
    $userAddress = trim($_POST['address']);
    $phoneNumber = trim($_POST['phone']);

    if(empty($email) && empty($name) && empty($password) && empty($confirm_password)){
        $error .= "Please make sure to fill in all the boxes <br>";

    }else if(empty($email) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)){
        $error .= "Please enter a valid email address <br>";

    }else if(empty($name) || !preg_match("/^[a-zA-Z_ ]*$/", $name)){
        $error .= "Please enter a valid name <br>";

    }else if(empty($password)){
        $error .= "Please enter your password <br>";

    }else if(strlen($password) < 8){
        $error .= "Password must be at least 8 characters long <br>";

    }

    if(empty($error)){
        $password = hash("sha1", $password);

        $result = $profileUpdate->updateUserInfo($name, $userURL, $email, $phoneNumber, $userAddress, $password);

        if($result == 1){
            session_unset();
            session_destroy();
            echo "<script>window.open('../../login','_self')</script>";
        }

        if($result == 2){
            $validationError .= "The password is wrong. <br>";
        }

        if($result == 3){
            $validationError .= "Oops, Something went wrong. <br>";
        }
        
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Update user information</title>
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

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header bg-black d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="../../public/assets/img/logo.png" alt=""> -->
        <h1>Welfare</h1>
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

          <?php 
          
            if(isset($_SESSION['user_url'])){
              echo "<li><a class='get-a-quote' href='users/account'>My account</a></li>";
            }else{
              echo "<li><a class='get-a-quote' href='login'>Login</a></li>";
            }

          
          ?>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <!-- End Header -->

<br>
<br>

<?php

  if(isset($_SESSION['user_url'])){

?>

    <div class="container">
        
        <br>
        <section class="register-form">
        <p>Welcome <?php echo ucfirst($username); ?></p>
            <h3 class="section-subtitle">Update personal information.</h3>
            <h6 style="color: red"><?php echo $validationError; ?></h6>
            <h6 style="color: red"><?php echo $error; ?></h6>
            <br>
            <div class="form-control">
                
                <form action="costumer-info.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Name :</label> 
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" value="<?=$oldUsername?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email :</label> 
                        <input type="email" name="email" value='<?=$oldEmail?>' class="form-control" placeholder="Enter your email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Enter your phone number:</label>
                        <input id="phone" class="form-control"  type="tel" value="<?=$phoneNumber?>" name="phone" />
                    </div>
                    
                    <!-- Checking if the phone number verified or not -->

                    <div class="mb-3">
                        <label class="form-label">CIN:</label>
                        <input id="cin" class="form-control"  type="tel" value="<?=$userCIN?>" name="cin" />
                    </div>

                    <!-- Checking if the phone number verified or not -->

                    <div class="mb-3">
                        <label class="form-label">Address :</label> 
                        <input type="text" name="address" class="form-control" value="<?=$userAddress?>" placeholder="Enter your address">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Enter your password:</label> 
                        <input type="password" name="confirmation_password" class="form-control" placeholder="Enter your password to update your information.">
                    </div>

                    <br>
                    <div class="">
                      <div class="row row-cols-auto">

                        <button type="submit" name="update-info" class="col btn btn-success mx-3">Update my information</button>

                        <a href="../../private/update/restore-password?email=<?=$oldEmail?>" name="change-password" class="col btn btn-danger mx-3">Forgot your password?</a>

                      </div>
                    </div>
                </form>
                <br>
                
            </div>
        </section>

    </div>

    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        function getIp(callback) {
        fetch('https://ipinfo.io/json?token=<your token>', { headers: { 'Accept': 'application/json' }})
        .then((resp) => resp.json())
        .catch(() => {
            return {
            country: 'us',
            };
        })
        .then((resp) => callback(resp.country));
        }

        // const phoneInput = window.intlTelInput(phoneInputField, {
        // initialCountry: "auto",
        // geoIpLookup: getIp,
        // utilsScript:
        // "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        // });

        // const phoneInput = window.intlTelInput(phoneInputField, {
        // preferredCountries: ["us", "co", "in", "de"],
        // utilsScript:
        //     "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        // });

    </script>

    
<?php

}else{
?>

<h1 class="container mt-5">Hello &#128149; </h1>
<div class="container mx-auto p-5 text-white bg-black fs-4">
    <p>Please make sure to Log in if you already have an account, or please join us by creating an account.</p>

    <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
      <a href="../../../login.php" class="btn btn-dark fs-5">Log in &nbsp; <i class='bx bx-log-in'></i></a>
      <a href="../../../register.php" class="btn btn-dark fs-5"> Register &nbsp; <i class='bx bxs-user-plus'></i> </a>
    </div>
</div>


<?php
}

?>

 </body>
</html>