<?php
require_once "./functions/helper.php";
require_once "./functions/Message.php";
require_once "./functions/OldInputs.php";

session_start();

// action:sendEmail
$action = $_POST['action'] ?? null; // 'sendEmail'

if(!empty($action)){
    $action(); //sendEmail()
}

function sendEmail(){
    $name = clear($_POST['name'] ?? '');
    $phone = clear($_POST['phone'] ?? '');
    $message = clear($_POST['message'] ?? '');


 

   if(empty($name)){
  Message::set('Name is required', 'danger');
  OldInputs::set($_POST);
    redirect('contacts');
   }
   if(empty($phone)){
    Message::set('Phone is required', 'danger');
    OldInputs::set($_POST);
    redirect('contacts');
   }
   if(empty($message)){
    Message::set('Message is required', 'danger');
    OldInputs::set($_POST);
    redirect('contacts');
   }




    mail('rnb1606770@gmail.com', 'Mail from site', "$name, $phone, $message");
    
    Message::set('Thank!');
    redirect('contacts');

}

function sendFile(){
    dump($_FILES['file']);
    extract($_FILES['file']); //деструктуризация асоциативного массива

    if($error === 4){
        Message::set('File is required', 'danger');
        redirect('uploads');
    }

    if($error !== 0){
        Message::set('File is not required', 'danger');
        redirect('uploads');
    }

    $allowedFiles = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
    if(!in_array($type, $allowedFiles)){
        Message::set('File is not image', 'danger');
        redirect('uploads');
    }


    $ext = end(explode('.', $name));
    $fName = md5(time() . uniqid() . session_id()) . '.' . $ext;
    
    if(!file_exists('uploads'))
    mkdir('uploads');

    move_uploaded_file($tmp_name, './uploads/' . $fName);

    // изменение размеров изображения
  resizeImage('./uploads/' . $fName, 200, true);
  resizeImage('./uploads/' . $fName, 300, false);

    Message::set('File is uploaded!');
    redirect('uploads');
}


function registerUser(){
    $email = clear($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $repeatPassword = $_POST['repeat_password'] ?? '';

    // Проверки на ошибки
    if (empty($email) || empty($password) || empty($repeatPassword)) {
        Message::set('All fields are required', 'danger');
        OldInputs::set($_POST);
        redirect('registration');
    }

    if ($password !== $repeatPassword) {
        Message::set('Passwords do not match', 'danger');
        OldInputs::set($_POST);
        redirect('registration');
    }

    // Загрузка существующих пользователей из файла
    $users = loadUsers();

    // Проверка на существование пользователя с таким email
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            Message::set('User with this email already exists', 'danger');
            OldInputs::set($_POST);
            redirect('registration');
        }
    }

    // Если все верно, регистрируем пользователя и сохраняем в файл
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $users[] = ['email' => $email, 'password' => $hashedPassword];
    saveUsers($users);

    Message::set('Registration successful', 'success');
    redirect('/');
}

// Загрузка пользователей из файла
function loadUsers()
{
    $usersFile = 'users.json';
    if (file_exists($usersFile)) {
        $usersData = file_get_contents($usersFile);
        return json_decode($usersData, true);
    }
    return [];
}

// Сохранение пользователей в файл
function saveUsers($users)
{
    $usersFile = 'users.json';
    $usersData = json_encode($users);
    file_put_contents($usersFile, $usersData);
}


function loginUser(){
    $email = clear($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Проверки на ошибки
    if (empty($email) || empty($password)) {
        Message::set('Email and password are required', 'danger');
        OldInputs::set($_POST);
        redirect('login');
    }

    // Загрузка существующих пользователей из файла
    $users = loadUsers();

    // Поиск пользователя по email
    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            // Если данные верны, сохраняем пользователя в сессию
            $_SESSION['user'] = $email;
            redirect('/');
        }
    }

    Message::set('Invalid email or password', 'danger');
    OldInputs::set($_POST);
    redirect('login');
}

function exitUser(){
    unset($_SESSION['user']);
    redirect('/');
}

function resizeImage($filePath, $size, $crop)
{
  extract(pathinfo($filePath));
  $extension = strtolower($extension) === 'jpg' ? 'jpeg' : $extension;
  $functionCreate = 'imagecreatefrom' . $extension; // 'imagecreatefromjpeg'

  $src = $functionCreate($filePath);

  list($src_width, $src_height) = getimagesize($filePath);

  if ($crop) {
    // обрезка
    $dest = imagecreatetruecolor($size, $size);
    $filename .= "-{$size}x{$size}";
    if ($src_width > $src_height) {
      // если горизонтальное исх. изобр.
      imagecopyresized($dest, $src, 0, 0, $src_width / 2 - $src_height / 2, 0, $size, $size, $src_height, $src_height);
    } else {
      // если вертикальное исх. изобр.
      imagecopyresized($dest, $src, 0, 0, 0, $src_height / 2 - $src_width / 2, $size, $size, $src_width, $src_width);
    }
  } else {
    // пропорциональное изменение
    $dest_width = $size;
    $dest_height = round($dest_width / ($src_width / $src_height));

    $dest = imagecreatetruecolor($dest_width, $dest_height);
    $filename .= "-{$dest_width}x{$dest_height}";
    imagecopyresized($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
  }

  $functionSave = 'image' . $extension;

  if(strtolower($extension) === 'jpg')
    imagejpeg($dest, "$dirname/$filename.$extension", 100); // сохранение изображения
  else
    $functionSave($dest, "$dirname/$filename.$extension");
}





function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return;
    }

    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = "$dir/$file";
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}


function sendReview(){
    $name =clear($_POST['name']?? '');
    $review =clear($_POST['review']?? '');
    $time = time();

    if(empty($name) || empty($review)){
        Message::set('Form with errors1', 'danger');
        redirect('reviews');
    } 

    $reviews = file_exists('reviews.txt') ? json_decode(file_get_contents('reviews.txt')) : [];

    $reviews[] = compact('name', 'review', 'time'); // ['name'=>'Bob', 'review'=>'tertert', 'time'=>164234325]

    $f = fopen('reviews.txt', 'w');
    fwrite($f, json_encode($reviews));
    fclose($f);

    Message::set('Thank!');
    redirect('reviews');
}