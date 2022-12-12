<?php

include "../app/classes/databaseClass.php";
include "../app/classes/profileClass.php";

session_start();
$userPhoneNumber = "";

if(isset($_SESSION['user_email'])){
  $email = $_SESSION['user_email'];
}else{
  $email ='';
}

$getProfile = new Profile();

$result = $getProfile->getProfileImg($email);
if($result != 0){
  $user_image = $result;
}

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


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
            <img src="uploads/img/<?= $user_image ?>" id='userProfilePicture' />
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

        <form action="./update/updateImage.php" method="post" id='updatePictureForm' enctype="multipart/form-data">

          <input name="uploaded-image" id="newImagePicture" class="fileInput" type="file">
          <ul class="about">

            <li> 
            
              <input type="submit" id="submitProfilePicture" name="update-profile" value="Upload picture" class="btn mx-auto btn-primary"
                      style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
            </li>

            <li> Update Info </li>
            <li> Add Post </li>
          </ul>
        </form>

          <div class="content">
            <p>
              <?php

                if(isset($_SESSION['user_about'])){
                  echo $_SESSION['user_about'];
                }

              ?>
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
            <li><a href="../feed">Feed</a></li>
              <li><a href="../about">About</a></li>
              <li><a href="../report">Report</a></li>
              <li><a href="../map">Mapping</a></li>
              <li><a href="../contact">Contact</a></li>
            </ul>
            <button>Follow</button>
          </nav>

          <div class="photos">
            
          <form action="" method="post" enctype="multipart/form-data">
            <input type="submit" id="" name="" value="post a picture" class="btn mx-auto btn-secondary"
                      style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
          </form>

            <!-- <img src="assets/img/img_1.avif" alt="Photo" />
            <img src="assets/img/img_2.avif" alt="Photo" />
            <img src="assets/img/img_3.avif" alt="Photo" />
            <img src="assets/img/img_4.avif" alt="Photo" />
            <img src="assets/img/img_5.avif" alt="Photo" />
            <img src="assets/img/img_6.avif" alt="Photo" /> -->
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

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

<script>
      $(document).ready(function(){
        $("#submitProfilePicture").click(function(e){
          e.preventDefault();

          let form_data = new FormData();
          let imgProfile = $("#newImagePicture")[0].files;

          if(imgProfile.length > 0){
            form_data.append("newImagePicture", imgProfile[0]);

            $.ajax({
              url: './update/updateImage.php',
              type: 'post',
              data: form_data,
              contentType: false,
              processData: false,
              success: function(res){
                const data = JSON.parse(res);

                if(data.error != 1){
                  let path = "./uploads/img/" + data.src;
                  $("#userProfilePicture").attr("src", path);
                  $("#userProfilePicture").fadeOut(1).fadeIn(1000);

                }else{
                  $("#errorMessage").text(data.em);
                }

              }
            });
            
          }else{
            $("#errorMessage").text("Please select an image.");
          }

        })
      });
    </script>

  </body>
</html>


