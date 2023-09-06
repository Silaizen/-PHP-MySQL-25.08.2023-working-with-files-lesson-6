<?php 
require_once "./functions/main.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        .swiper-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .swiper-wrapper {
            display: flex;
            align-items: center;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .swiper-slide img {
            max-width: 150px;
            max-height: 150px;
            margin: 0 auto;
            cursor: pointer;
        }
    </style>



</head>

<body>
    <header>
      
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php?page=uploads">Uploads</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./index.php?page=contacts">Contacts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./process_form.php?page=contacts">Form</a>
        </li>
        <li class="nav-item">
    <a class="nav-link" href="./index.php?page=manage_sliders">Manage Sliders</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="./index.php?page=gallery">Gallery</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="./index.php?page=reviews">Reviews</a>
</li>



        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    
    <?php if (!isset($_SESSION['user'])): ?>
        <li class="nav-item">
            <a class="nav-link" href="./index.php?page=login">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./index.php?page=registration">Registration</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <form method="POST" action="index.php">
                <button class="nav-link" type="submit" name="action" value="exitUser">Logout</button>
            </form>
        </li>
    <?php endif; ?>
</ul>
       


      </ul>
     
    </div>
  </div>
</nav>
    </header>

<div class="container">

    <?php
   

   $page = $_GET['page'] ?? 'home';
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['createSlider'])) {
        // Код для создания слайдера
        $sliderName = clear($_POST['sliderName'] ?? '');

        if (!empty($sliderName)) {
            if (!file_exists('./uploads/' . $sliderName)) {
                mkdir('./uploads/' . $sliderName);
            }
        }
    } elseif (isset($_POST['uploadImages'])) {
        // Код для загрузки изображений в слайдер
        $selectedSlider = clear($_POST['sliderSelect'] ?? '');

        if (!empty($selectedSlider) && isset($_FILES['sliderImages'])) {
            $sliderDirectory = './uploads/' . $selectedSlider;

            foreach ($_FILES['sliderImages']['tmp_name'] as $index => $tmpName) {
                $fileType = $_FILES['sliderImages']['type'][$index];
                $ext = strtolower(pathinfo($_FILES['sliderImages']['name'][$index], PATHINFO_EXTENSION));

                if (in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
                    $filename = md5(time() . uniqid() . session_id()) . '.' . $ext;
                    move_uploaded_file($tmpName, $sliderDirectory . '/' . $filename);
                    resizeImage($sliderDirectory . '/' . $filename, 150, true);
                }
            }
        }
    } elseif (isset($_POST['deleteSliderBtn'])) {
        // Код для удаления слайдера
        $sliderToDelete = clear($_POST['deleteSlider'] ?? '');

        if (!empty($sliderToDelete)) {
            $sliderDirectory = './uploads/' . $sliderToDelete;

            if (is_dir($sliderDirectory)) {
                deleteDirectory($sliderDirectory);
            }
        }
    }
}





   if (file_exists(" ./pages/$page.php"))
   require_once " ./pages/$page.php";
   else 
   echo "<h1>Page Not Found</h1>";
   OldInputs::remove();


    if ($page === 'form') {
      require_once "./pages/form.php";
  } elseif (file_exists("./pages/$page.php")) {
      require_once "./pages/$page.php";
  } else {
      echo "<h1>Page Not Found</h1>";
  }

    ?>


<?php if (isset($_SESSION['user'])): ?>
    <form method="POST" action="index.php">
        <button>Выход</button>
        <input type="hidden" name="action" value="exitUser">
    </form>
<?php endif; ?>


</div>
    <footer>Footer</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
</body>
</html> 



