
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fio = $_POST['fio'] ?? '';
    $password = $_POST['password'] ?? '';
    $disk = $_POST['disk'] ?? '';
    $courses = $_POST['courses'] ?? [];
    $delivery = $_POST['delivery'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (empty($fio) || empty($password) || empty($disk) || empty($courses) || empty($delivery) || empty($address) || empty($email)) {
        header("Location: ./index.php?page=form");
        exit;
    }
    

    $to = $email;
    $subject = 'Данные из формы';
    $message = "ФИО: $fio\nПароль: $password\nТип диска: $disk\nКурсы: " . implode(', ', $courses) . "\nСпособ доставки: $delivery\nАдрес доставки: $address\nEmail: $email";
    mail($to, $subject, $message);
    
    
    header("Location: ./index.php?page=success");
    exit;
} else {
    header("Location: ./index.php?page=form");
    exit;
}
?>