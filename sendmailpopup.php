<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$text = $_POST['message'];

// Формирование самого письма
$title = "Новая заявка";
$body = "
<b>Имя:</b> $name<br>
<b>Почта:</b> $email<br>
<b>Номер телефона:</b> $phone<br>
<b>Город:</b> $city<br><br>
<b>Сообщение:</b><br>$text
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
   $mail->Host = 'ssl://smtp.mail.ru';
    $mail->Username   = 'adil_miermanov@mail.ru'; // Логин на почте
    $mail->Password   = 'QLNwP9AcSYkceExkfQtG'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('adil_miermanov@mail.ru', 'Matheducation.kz'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('nbekaulov@gmail.com' , 'Matheducation.kz'); // Ещё один, если нужен

    // Прикрипление файлов к письму

// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {
	$result = "success";
	$message = 'Данные отправлены!';
} 
else {$result = "error";}
$message = 'Ошибка';
} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
$response = ['message' => $message];
// Отображение результата
echo json_encode(["result" => $result,  "status" => $status, $response]);