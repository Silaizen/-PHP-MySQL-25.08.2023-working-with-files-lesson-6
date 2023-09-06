<?php
function clear($str){
    return trim(strip_tags($str));
}

function redirect($page){
    header('Location: index.php?page=' . $page); //перенаправление
    exit();
}

function dump($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}