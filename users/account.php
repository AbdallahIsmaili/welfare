<?php

session_start();
$userPhoneNumber = "";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welfare - <?php echo (isset($_SESSION['user_url'])) ? $_SESSION['user_name'] : 'My account'; ?> </title>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/assets/css/all.min.css"
    />

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>

  <?php

    if(isset($_SESSION['user_url'])){

  ?>

  <body>
    <div class="header__wrapper">
      <header></header>
      <div class="cols__container">
        <div class="left__col">
          <div class="img__container">
            <img src="uploads/img/no-profile.webp" alt="Anna Smith" />
            <span></span>
          </div>
          <h2><?= ucfirst($_SESSION['user_name'])?></h2>
          <p><?=$_SESSION['user_email']?></p>
          <?php
            
            if($_SESSION['user_phone'] == 'no phone'){
              $userPhoneNumber = $_SESSION['user_phone'];

              echo "<a href='update/my-phone'>$userPhoneNumber <i class='bx bx-edit bx-tada' ></i></a>";

            }else{
              echo "<p>$userPhoneNumber</p>";
            }
            
          ?>

          <ul class="about">
            <li><span>4,073</span>Followers</li>
            <li><span>322</span>Following</li>
            <li><span>200,543</span>Attraction</li>
          </ul>

          <div class="content">
            <p>
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
              erat volutpat. Morbi imperdiet, mauris ac auctor dictum, nisl
              ligula egestas nulla.
            </p>

            <ul>
              <li><i class="fab fa-twitter"></i></li>
              <i class="fab fa-pinterest"></i>
              <i class="fab fa-facebook"></i>
              <i class="fab fa-dribbble"></i>
            </ul>
          </div>
        </div>
        <div class="right__col">
          <nav>
            <ul>
            <li><a href="../home">Home</a></li>
              <li><a href="../about">About</a></li>
              <li><a href="../report">Report</a></li>
              <li><a href="../map">Mapping</a></li>
              <li><a href="../contact">Contact</a></li>
            </ul>
            <button>Follow</button>
          </nav>

          <div class="photos">
            <img src="assets/img/img_1.avif" alt="Photo" />
            <img src="assets/img/img_2.avif" alt="Photo" />
            <img src="assets/img/img_3.avif" alt="Photo" />
            <img src="assets/img/img_4.avif" alt="Photo" />
            <img src="assets/img/img_5.avif" alt="Photo" />
            <img src="assets/img/img_6.avif" alt="Photo" />
          </div>
        </div>
      </div>
    </div>

    <?php
      }else{
    ?>

    <div class="header__wrapper">
      <header></header>
      <div class="cols__container">
        <div class="left__col">
          <div class="img__container">
            <img src="assets/img/anonymous.png" alt="" />
          </div>
          <h2>Anonymous</h2>

          <div class="content">
            <p>
            Hello there! we are happy that you are interested to know more about our service, and of course, we want you to become one of us. Let's stay safe and keep our world safe.
            </p>

          </div>
        </div>
        <div class="right__col">
          <nav>
            <ul>
              <li><a href="../home">Home</a></li>
              <li><a href="../about">About</a></li>
              <li><a href="../report">Report</a></li>
              <li><a href="../map">Mapping</a></li>
              <li><a href="../contact">Contact</a></li>
            </ul>
            <button><a style="color: white" href="../login">Sign in</a></button>
          </nav>

          <div class="photos">
            <button> <a href="../register">Sign up</a> </button>
          </div>
        </div>
      </div>
    </div>

    <?php
      }
    ?>

  </body>
</html>


