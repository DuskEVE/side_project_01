<?php
include_once "./api/db.php";
$menus = $Type->searchAll(['display'=>1]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/dusk.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.4/gsap.min.js" integrity="sha512-EZI2cBcGPnmR89wTgVnN3602Yyi7muWo8y1B3a8WmIv1J9tYG+udH4LvmYjLiGp37yHB7FfaPBo8ly178m9g4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
</head>
<body class="dusk-bg-gray">

  <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="login-modal-label" aria-hidden="true">
    <?php include "./modal/login.php"; ?>
  </div>

  <div class="modal fade" id="add-type-modal" tabindex="-1" aria-hidden="true">
    <?php include "./modal/add_type.php"; ?>
  </div>

  <div class="modal fade" id="edit-banner-modal" tabindex="-1" aria-hidden="true">
    <?php include "./modal/edit_banner.php"; ?>
  </div>

  <div class="modal fade" id="news-view-modal" tabindex="-1" aria-hidden="true">
    <?php include "./modal/view_news.php"; ?>
  </div>

  
  <div class="modal fade" id="update-news-modal" tabindex="-1" aria-hidden="true">
    <?php include "./modal/update_news.php"; ?>
  </div>

  <div class="modal fade" id="gallery-view-modal" tabindex="-1" aria-hidden="true">
    <?php include "./modal/view_gallery.php"; ?>
  </div>


  <div class="top">
    <?php
      $banner;
      if(isset($_GET['type']) && $Banner->count(['type_id'=>$_GET['type']])!=0){
        $banner = $Banner->search(['type_id'=>$_GET['type']])['img'];
      }
      else $banner = $Banner->search(['type_id'=>0])['img'];
      echo "<div class='top-img' style='background-image: url(./banner/$banner);'></div>";
    ?>

  </div>

  <div class="nav-placeholder"></div>
  <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand ms-3 me-3" href="./index.php">Dusk</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-3 me-auto mb-2 mb-lg-0">

            <li class="nav-item me-3">
              <a class="nav-link" href="./index.php?do=news">News</a>
            </li>

            <li class="nav-item dropdown me-3">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Gallery
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./index.php?do=gallery">All</a></li>
                <li><hr class="dropdown-divider"></li>
                <div id="gallery-nav">
                <?php
                foreach($menus as $menu){
                  echo "
                    <li><a class='dropdown-item' href='./index.php?do=gallery&type={$menu['id']}'>{$menu['name']}</a></li>
                    <li><hr class='dropdown-divider'></li>
                  ";
                }
                ?>
                </div>
                <?php
                if(isset($_SESSION['user'])){
                  echo "
                    <li><a class='dropdown-item' href='./index.php?do=gallery&user={$_SESSION['user']}'>My gallery</a></li>
                    <li><hr class='dropdown-divider'></li>
                    <li><a class='dropdown-item' href='./index.php?do=upload_gallery'>upload image</a></li>
                  ";
                }
                ?>
              </ul>
            </li>
          </ul>

          <div class="d-flex align-items-center ms-3">
            <?php
              if(isset($_SESSION['user'])){
                echo "<span class='text-light me-2'>歡迎!{$_SESSION['user']}</span>";
                
                if(isset($_SESSION['admin'])) include "./front/option_admin.php";
                else include "./front/option_user.php";

                echo "<button class='btn btn-outline-success logout-btn ms-3 me-3'>logout</button>";
              }
              else echo "<button class='btn btn-outline-success login-btn'>login</button>";
            ?>
          </div>
        </div>
      </div>
  </nav>

  <div class="container dusk-bg-lightgray">
    <?php
    // 透過get是否有ad或do來判斷要include的頁面
    if(isset($_GET['do'])){
      $file = "./front/{$_GET['do']}.php";
      if(file_exists($file)) include $file;
      else include "./front/main.php";
    }
    else if(isset($_GET['ad'])){
      $file = "./back/{$_GET['ad']}.php";
      if(file_exists($file)) include $file;
      else include "./front/main.php";
    }
    else include "./front/main.php";
    ?>
  </div>

  <div class="footer bg-dark text-light d-flex justify-content-center align-items-center">
      <span class="m-auto">page footer</span>
  </div>
  
  <script src="./js/dusk.js"></script>
</body>
</html>