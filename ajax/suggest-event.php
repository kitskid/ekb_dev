<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die();
}

$phone = trim($_POST['phone'] ?? '');
$city = trim($_POST['city'] ?? '');
$description = trim($_POST['description'] ?? '');

$errors = array();

if (empty($phone)) {
    $errors[] = 'Укажите номер телефона';
}

if (empty($city)) {
    $errors[] = 'Укажите город';
}

if (empty($description)) {
    $errors[] = 'Опишите ваше предложение';
}

if (!empty($errors)) {
    header('Content-Type: application/json');
    echo json_encode(array(
        'success' => false,
        'errors' => $errors
    ));
    exit;
}

// Отправка email администратору
$to = "admin@site.ru"; // Замените на нужный email
$subject = "Новое предложение события";
$message = "
Получено новое предложение события:

Телефон: {$phone}
Город: {$city}
Описание: {$description}

Дата отправки: " . date('d.m.Y H:i:s') . "
IP: " . $_SERVER['REMOTE_ADDR'];

$headers = "From: noreply@site.ru\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";

$mailSent = mail($to, $subject, $message, $headers);

// Также можно сохранить в базу данных или инфоблок
// ...

header('Content-Type: application/json');
echo json_encode(array(
    'success' => $mailSent,
    'message' => $mailSent ? 'Предложение отправлено' : 'Ошибка отправки'
));
?>