<?php
include $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/PHPMailer.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/SMTP.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/Exception.php';

/*include $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
include $_SERVER['DOCUMENT_ROOT'].'/vendor/mpdf/mpdf/mpdf.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/phpqrcode/qrlib.php';*/

require_once $_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/vendor/mpdf/mpdf/mpdf.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/libs/phpqrcode/qrlib.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/libs/NCL/NCLNameCaseRu.php';


function __FilterStrStrong($str){return htmlspecialchars(strip_tags(preg_replace("/[^a-zA-Z0-9_-]/i",'',trim($str))),ENT_QUOTES);}//для токена
function __FilterStr($str){return htmlspecialchars(strip_tags(preg_replace("/[^a-zA-Z0-9.;:|#@_ -]/i",'',trim($str))),ENT_QUOTES);}//текс лайтовый
function __FilterInt($str){return preg_replace("/[^0-9]/i",'',trim($str));} // только цифры
function __FilterText($str){return htmlspecialchars(strip_tags(trim($str)),ENT_QUOTES);} //html фильтрация текста
function __ConvertAjaxUTF($A){foreach($A as &$v){$v=iconv("UTF-8","windows-1251",$v);}return $A;}
function __ConvertUTFArray($A){foreach($A as &$v){$v=iconv("UTF-8","windows-1251",$v);}return $A;}
function __ConvertWINtoUTFArray($A){foreach($A as &$v){$v=iconv("windows-1251","UTF-8",$v);}return $A;}
function debug($data){echo '<pre>' . print_r($data, 1) . '</pre>';}
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

function get_url_contents($url){
    if (function_exists('file_get_contents')) {
        $result = @file_get_contents($url);
    }
    if ($result == '') {
        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    return $result;
}
function getUserById($id){
    global $connect;
    $resultsUser=mysqli_query($connect,"SELECT nickname, score FROM user WHERE id=".$id." LIMIT 1");
    if(mysqli_num_rows($resultsUser)==1){
      return mysqli_fetch_assoc($resultsUser);
    } else {
        return false;
    }
}

function strToInt ($str){
    return abs( crc32( $str ) );
}



function sendMail($data){

    $arrResut = array();

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        // Параметры SMTP-сервера
        //$mail->SMTPDebug = 2;                                 // Раскомментируйте для вывода отладочной информации
        $mail->isSMTP();                                        // Указываем, что модуль будет работать в режиме SMTP
        $mail->Host = 'smtp.yandex.ru';                         // Адрес сервера SMTP
        $mail->SMTPAuth = true;                                 // Включение аутентификации SMTP
        $mail->Username = 'tickets@karelforum.ru';                         // Адрес полностью, если используется почта для домена.
        $mail->Password = '123Qwerty123';
        $mail->SMTPSecure = 'ssl';                              // Включение шифрования TLS, как вариант можно 'ssl'
        $mail->Port = 465;                                      // TCP-порт, для Яндекса работает именно такой


        // Получатели
        $mail->setFrom('tickets@karelforum.ru', 'Robot');        // Отправитель
        $mail->addAddress('bilet@karelforum.ru', 'User Name');     // Добавление получателя, в таком виде можно указать несколько
        //$mail->addAddress('contact@example.com');             // Имя можно не указывать
        //$mail->addReplyTo('info@example.com', 'Info');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Вложенные файлы
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Добавление файла, в таком виде можно указать несколько
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Имя можно не указывать

        // Контент письма
        $mail->CharSet = 'UTF-8';                               // Кодировка для всех текстов
        $mail->isHTML(true);                                    // Включение HTML-формата
        $mail->Subject = $data['title'];
        $mail->Body    = $data['body'];
        //$mail->AltBody = 'Вариант текста письма для почтовых программ, не поддерживающих HTML';

        // Отправка
        $mail->send();
        $arrResut['STATUS']='SACCES';

    } catch (Exception $e) {
        $arrResut['STATUS']='ERROR';
        $arrResut['ERROR_MSG']='Ошибка: ' . $mail->ErrorInfo;
    }


    return $arrResut;

}




function sendMailTikets($data){



    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        // Параметры SMTP-сервера
        //$mail->SMTPDebug = 2;                                 // Раскомментируйте для вывода отладочной информации
        $mail->isSMTP();                                        // Указываем, что модуль будет работать в режиме SMTP
        $mail->Host = 'smtp.yandex.ru';                         // Адрес сервера SMTP
        $mail->SMTPAuth = true;                                 // Включение аутентификации SMTP
        $mail->Username = 'tickets@karelforum.ru';                         // Адрес полностью, если используется почта для домена.
        $mail->Password = '123Qwerty123';
        $mail->SMTPSecure = 'ssl';                              // Включение шифрования TLS, как вариант можно 'ssl'
        $mail->Port = 465;                                      // TCP-порт, для Яндекса работает именно такой


        // Получатели
        $mail->setFrom('tickets@karelforum.ru', 'Карел формум 2022');        // Отправитель
        $mail->addAddress($data['email']);     // Добавление получателя, в таком виде можно указать несколько
        //$mail->addAddress('contact@example.com');             // Имя можно не указывать
        //$mail->addReplyTo('info@example.com', 'Info');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Вложенные файлы

        foreach ($data['pdf'] as $pdf){
            $mail->addAttachment($pdf);
        }

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Добавление файла, в таком виде можно указать несколько
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Имя можно не указывать

        // Контент письма
        $mail->CharSet = 'UTF-8';                               // Кодировка для всех текстов
        $mail->isHTML(true);                                    // Включение HTML-формата
        $mail->Subject = $data['title'];
        $mail->Body    = $data['body'];
        //$mail->AltBody = 'Вариант текста письма для почтовых программ, не поддерживающих HTML';

        // Отправка
        $mail->send();
        $arResult['SACCES']='Y';

        return $arResult;
    } catch (Exception $e) {
        $arResult['EROOR'] = 'Не удалось отправить письмо.';
        $arResult['EROOR_TEXT']= 'Ошибка: ' . $mail->ErrorInfo;

        return $arResult;
    }




}

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

function initPay($requestId, $amount){

    $merchantId = '22171';

    $arResult=array();

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nonce=generate_string($permitted_chars, 32);

    $timestamp = (time()*1000);

    $checkValue= $merchantId.$nonce.$timestamp;

    //$requestId = 24;
    //$amount = 1;
    $description ='Олпата билета';

// $data содержит данные для генерации подписи

// Извлекаем секретный ключ из файла и подготавливаем


    $privatKey = "file://".__DIR__.DIRECTORY_SEPARATOR."private.ec.key";

    $pkeyid = openssl_pkey_get_private($privatKey);
    openssl_sign($checkValue, $signature, $pkeyid, OPENSSL_ALGO_SHA512);

    $data = [
        'merchantId' => $merchantId,
        'nonce' => $nonce,
        'timestamp' => $timestamp,
        'checkValue'=> bin2hex($signature),
        'requestId'=>$requestId,
        'nextAction'=>'processPayment',
        'amount'=> $amount,
        'currency' => 643,
        'description' => $description,
        'urlAfterPaymentProcessed' => 'https://pay.karelforum.ru/result.php',
        'paymentCompletedCallbackUrl'=> 'https://pay.karelforum.ru/result_post.php'

    ];

    $arResult['log']=$data;
    $dataString = json_encode($data, true);

    $url = 'https://ecom.payment-guide.ru/api/e-commerce/v1/initSession';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($dataString)
    ]);
    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    //print '<pre>'; print_r($result); print '</pre>';
    //print '<pre>'; print_r($httpcode); print '</pre>';

    $arResult['status']=$httpcode;
    $arResult['data']=json_decode($result,true);

    return $arResult;
}

function statusPay($arr=array()){


    $merchantId = '22171';

    $arResult=array();

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nonce=generate_string($permitted_chars, 32);

    $timestamp = (time()*1000);

    $checkValue= $merchantId.$nonce.$timestamp;

    //$requestId = 24;
    //$amount = '10';
    $description ='Олпата билета';

// $data содержит данные для генерации подписи

// Извлекаем секретный ключ из файла и подготавливаем


    $privatKey = "file://".__DIR__.DIRECTORY_SEPARATOR."private.ec.key";

    $pkeyid = openssl_pkey_get_private($privatKey);
    openssl_sign($checkValue, $signature, $pkeyid, OPENSSL_ALGO_SHA512);
    //$arResult['log']=$privatKey;
    $data = [
        'requestId'=>__FilterStrStrong($arr['requestId']),
        'rrn'=>__FilterStrStrong($arr['rrn']),
        'sessionId'=>__FilterStrStrong($arr['sessionId']),
        'merchantId' => $merchantId,
        'nonce' => $nonce,
        'timestamp' => $timestamp,
        'checkValue'=> bin2hex($signature),

    ];
    /*{
      "requestId": "123asdf",
      "rrn": "123568976",
      "sessionId": "string",
      "merchantId": "120",
      "nonce": "0123456789ABCDEFFEDCBA9876543210",
      "timestamp": 1593786321123,
      "checkValue": "2dbc2fd2358e1ea1b7a6bc08ea647b9a337ac92d"
    }*/

    $dataString = json_encode($data, true);

    $url = 'https://ecom.payment-guide.ru/api/e-commerce/v1/paymentStatus';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($dataString)
    ]);
    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    //print '<pre>'; print_r($result); print '</pre>';
    //print '<pre>'; print_r($httpcode); print '</pre>';

    $arResult['status']=$httpcode;
    $arResult['data']=json_decode($result,true);

    return $arResult;


}

function createdPDF($id){
    global $connect;
    $arResult =array();
    if (isset($id)){
        $id=__FilterInt($id);

        if(!empty($id) OR $id>0){
            $query = mysqli_query($connect,"SELECT * FROM customer  WHERE id = '".$id."' LIMIT 1");
            $ticket = mysqli_fetch_assoc($query);

            $users = json_decode($ticket['user']);
            $ids = join("','",$users);
            $users = mysqli_query($connect,"SELECT * FROM users  WHERE id IN ('$ids')");
            $arrUsers = array();
            while ($row = mysqli_fetch_assoc($users)){
                $arrUsers[]=$row;

            }
            //debug($ticket['price']);
            //debug($arrUsers);
        } else {
            $arResult['ERROR']='Y';
            $arResult['ERROR_TEXT']='Текст не указан';
        }


        /*Инфа для отправки на почту*/
        $mailSend['email'] =  $ticket['email'];
        $mailSend['title'] = "Билеты на участие Карел Форум 2022";
        $mailSend['body'] =  "Выши билеты";


        $price = number_format($ticket['price'], 0, ',', ' ');
        $dateDef='16.05.2022 - 20.05.2022';


        $html_mail='<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<p><span style="background-color: transparent; font-family: Arial; font-size: 10pt; white-space: pre-wrap;">Билет на Карелфорум</span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Здравствуйте, </span><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-weight: bold; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">'.$arrUsers[0]["name"].'</span><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">! Мы рады, что вы присоединились к Карелфоруму! </span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Ждем встречи с вами в Петрозаводске с 16 по 20 мая. </span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"> </p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt;"><strong><span style="font-family: Arial; background-color: transparent; font-style: italic; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Детали заказа</span></strong></span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"> </p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Вместе с лучшими заведениями Петрозаводска мы подготовили для вас специальные предложения, благодаря которым ваша поездка в Карелию станет еще более комфортной и насыщенной!</span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"> </p>
<div dir="ltr" style="margin-left: 0pt;" align="left">
<table style="border-collapse: collapse; table-layout: fixed; width: 100px; margin-left: auto; margin-right: auto; border: none;" border="1pt solid rgb(0, 0, 0)" cellpadding="5pt">
<tbody>
<tr style="height: 21pt;">
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 585.75px; padding: 5pt; border: 1pt solid #000000;" colspan="4" valign="top">
<p dir="ltr" style="line-height: 1.2; text-align: center; margin-top: 0pt; margin-bottom: 0pt;" align="center"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-weight: bold; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Скидки от наших партнеров </span></p>
</td>
</tr>
<tr style="height: 0pt;">
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; text-align: center; margin-top: 0pt; margin-bottom: 0pt;" align="center"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-weight: bold; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Партнер/активность</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; text-align: center; margin-top: 0pt; margin-bottom: 0pt;" align="center"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-weight: bold; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Описание</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; text-align: center; margin-top: 0pt; margin-bottom: 0pt;" align="center"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-weight: bold; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Скидка</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; text-align: center; margin-top: 0pt; margin-bottom: 0pt;" align="center"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-weight: bold; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Промокод</span></p>
</td>
</tr>
<tr style="height: 0pt;">
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Отель Фрегат</span></p>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"><a href="https://frigatehotel.ru/?ysclid=l13qv3ad1e">https://frigatehotel.ru/?ysclid=l13qv3ad1e</a>
></span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #262626; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Отель находится в центре Петрозаводска, на берегу Онежского озера. 80 номеров разной степени комфортности – </span><span style="font-size: 10pt; font-family: Arial; color: #171717; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">от Стандарта до Люкса. </span><span style="font-size: 10pt; font-family: Arial; color: #262626; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Для всех посетителей предусмотрены бесплатный Wi-Fi на всей территории, ресторан и охраняемая парковка. </span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Скидка 500 рублей с 16 по 20 мая   на каждый день брони </span></p>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Бронирование на сайте отеля</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">КарелФорум</span></p>
</td>
</tr>
<tr style="height: 0pt;">
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Отель Питер Инн</span></p>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"><a href="https://www.piterinn.ru/ru/ ">https://www.piterinn.ru/ru/ </a></span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #171717; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Из отеля легко добраться до любой точки Петрозаводска, в шаговой доступности есть торговые центры, городской парк и местные достопримечательности. </span><span style="font-size: 10pt; font-family: Arial; color: #262626; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">В отеле для посетителей работает р</span><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">есторан, суши-бар и лаундж-кафе.</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Скидка 10% </span></p>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">на проживание с 15 по 18 мая</span></p>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Бронирование на сайте отеля</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">карелкамень2022</span></p>
</td>
</tr>
<tr style="height: 0pt;">
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Сеть ресторанов  SUN project</span></p>
<br>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Удобное меню каждого заведения - </span><span style="font-size: 10pt; font-family: Arial; color: #2892ff; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"><a href="http://sunprojectptz.ru/">http://sunprojectptz.ru/</a></span></p>
<br>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Ссылки на ВК:</span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #2892ff; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"><a href="https://vk.com/sunprojectptz">https://vk.com/sunprojectptz</a></span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">⁃ Ресторан "Большой", улица Кирова, 2</span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"> ⁃ Ресторан-караоке "Ели- Пели”, улица Московская, 1 </span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"> ⁃ Ресторан «Белый Кролик», улица Максима Горького,25 </span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"> ⁃ Кафе «Мансарда», улица Анохина, 41</span></p>
<br><br>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">В каждом заведении есть комплексные завтраки и обеды, каждый вечер активности и спец предложения! </span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"> </span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">- Скидка 10% на чек в ресторанах сети </span></p>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-style: italic; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">*скидки и акции не суммируются, не действует на спец. предложения*</span></p>
<br>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">⁃ Скидка 50% на игру в боулинг для компании до 6 человек при предварительной брони дорожки по телефону 27-28-29. Боулинг-кафе «На крыше», улица Максима Горького, 25</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">KARELFORUM 2022</span></p>
</td>
</tr>
<tr style="height: 0pt;">
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Туристическая поездка в Кижи </span></p>
<br>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-style: italic; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">анонс мероприятия и продажа билетов появится на сайте karelforum.ru не позднее 01.05.2022</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #202020; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Музей-заповедник «Кижи» — один из крупнейших в России музеев под открытым небом. Это — уникальный историко-культурный и природный комплекс, являющийся особо ценным объектом культурного наследия народов России. Основа музейного собрания — ансамбль Кижского погоста входит в Список всемирного культурного и природного наследия ЮНЕСКО. </span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Скидка 20% на поездку</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">KFKIZHI</span></p>
</td>
</tr>
<tr style="height: 0pt;">
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Гала-ужин для экспонентов и участников Карелфорума </span></p>
<br>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-style: italic; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">анонс мероприятия и продажа билетов появится на сайте karelforum.ru не позднее 01.05.2022</span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Гала-ужин пройдет 16 мая в ресторане Большой  — отличная возможность пообщаться в неформальной обстановке с коллегами из отрасли, встретиться с новыми партнерами или старыми друзьями. </span></p>
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Фуршет, развлекательная программа, живая музыка и даже караоке! </span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">10% скидка на билет на гала-ужин </span></p>
</td>
<td style="vertical-align: top; overflow: hidden; overflow-wrap: break-word; width: 135.469px; padding: 5pt; border: 1pt solid #000000;" valign="top">
<p dir="ltr" style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; color: #333333; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">KFGALA</span></p>
</td>
</tr>
</tbody>
</table>
</div>
<p> </p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">*информация о возврате и условиях использования билеты</span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"> </p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">До встречи! </span></p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"> </p>
<p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">/Команда Карелфорум-2022</span></p>
<p><span style="font-size: 10pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"> </span></p>

</body>
</html>
';



        //Тип
        switch ($ticket['what']){
            case 'private_one_day':
            case 'company_one_day':
                $typeTicket='Один день';
                $dateDef=$ticket['date'].'.2022';
                $mailSend['body'] =  "- доступ на форум в один из дней на выбор <br>- посещение лекций и круглых столов в выбранный день<br>- участие в мастер-классах в выбранный день <br>- экскурсии на карельские карьеры и заводы в выбранный день<br><br><br>";
                break;
            case 'company_full_day':
            case 'private_full_day':
                $typeTicket='Стандартный';
                $mailSend['body'] = "- доступ на форума на все дни <br>- посещение лекций и круглых столов <br>- участие в мастер-классах <br>- экскурсии на карельские заводы и карьеры<br>- промокоды на скидку: <br>на проживание в отелях Петрозаводска<br>в сеть лучших рестаронов Петрозаводска<br>на поездку в музей-заповедник Кижи<br>на гала-ужин Карелфорума<br><br><br>";
                break;
            case 'private_stud_full_day':
                $typeTicket='Льготный для студентов до 23 лет';
                $mailSend['body'] = "- посещение форума во все дни<br>- посещение лекций и круглых столах<br>- участие в мастер-классах<br>- выезды на карельские заводы и карьеры<br><br><br>";
                break;
        }

        $mailSend['body'] =$html_mail;

        $i=1;
        foreach ($arrUsers as $user){
            $numberTikets = $id.'_'.$user['id'];

            $hash = base64_encode('ticket_'.$id.'_user_'.$user['id']); //dGlja2V0XzUwX3VzZXJfODY=

            QRcode::png('https://pay.karelforum.ru/check/?hash='.$hash.' ', $_SERVER['DOCUMENT_ROOT'] . '/upload/qr/'.$numberTikets.'.png','L', 5, 0);


            $html = '
            <html lang="ru">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title>Электронный билет #000'.$numberTikets.'</title>
                <style>
            
                html{margin:0 10px}body{font-family:"ttinterfaces";font-size:14px;line-height:1.5;color:#131729;background-color:#E5E5E5}.small{font-size:.65rem}.bold{font-weight:700}table{border-spacing:0;width:100%}table.items td{padding:.2rem .4rem;border-bottom:1px solid #ddd;}
                
                </style>
            </head>
            <body>
            <div style="background: #FFFFFF; border: 1px solid #D7D7D7; border-radius: 20px;">
                <table width="100%">
                <tr>
                <td width="33"></td>
                <td><div style="margin-left: 33px;font-weight: bold; font-size: 32px;">Электронный <br> билет #000'.$numberTikets.'</div></td>
                <td align="right"><div><img src="/i/ticket.png"></div></td>
                </tr>
                </table>
            </div>
            
            <table><tr><td height="20"></td></tr></table>    
            
            <div style="background: #FFFFFF; border: 1px solid #D7D7D7; border-radius: 20px 20px 0 0; padding: 20px 33px">
                <table width="100%">
                <tr>
                <td align="left"><div><img src="/i/logo_1.png"></div></td>
                <td align="center"><div><img src="/i/logo_2.png"></div></td>
                <td align="right"><div><img src="/i/logo_3.png"></div></td>
                </tr>
                </table>
            </div>
            <div style="background: #FFFFFF; border: 1px solid #D7D7D7; border-top: none; border-radius: 0 0 20px 20px; padding: 20px 33px">
                <div style="font-size: 21px; font-weight:bold;">
                    Тип: '.$typeTicket.'
                     <br>
                    Дата: '.$dateDef.'
                    <br>
                    Россия, Республика Карелия,  Петрозаводск, Шуйское шоссе, 13
                </div>
                <br>
                <table width="100%">
                <tr>
                <td align="left">
                    
                    <div style="font-size: 18px;">
                        Участники:
                        <br>
                        <div stule="font-size: 21px; font-weight: bold;">
                        '.$user["last_name"].' '.$user["name"].' '.$user["second_name"].'
                        </div>
                        <br>
                        <div>В стоимость билета входит:</div>
                         <table width="100%">
                            <tr style="vertical-align:middle">
                                <td><img src="/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Доступ на форума на все дни</td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Посещение лекций и круглых столов </td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Участие в мастер-классах</td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Экскурсии на карельские заводы и карьеры</td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Промокод на скидку на проживание в отелях Петрозаводска</td>
                            </tr>
                         </table>
                    </div>
                    <br>
                    <br>
                    <div style="font-size: 21px; font-weight: bold;">
                        Стоимость: <span style="color: #2F7135; font-weight: bold;">'.$price.' руб</span> 
                    </div>
                </td>
                <td align="right" valign="top"><div><img src="/upload/qr/'.$numberTikets.'.png"></div></td>
                </tr>
                </table>
            </div>
            
            <table><tr><td height="20"></td></tr></table>    
            
            <div style="background: #FFF3F3; border: 1px solid #FFF3F3; border-radius: 20px; padding: 20px 33px">
                <table width="100%">
                <tr>
                <td align="left" valign="top">
                    <div><img src="/i/ico_1.png"></div>
                    <br>
                    <div>Не забудьте средства <br> индивидуальной защиты!</div></td>
                <td align="left" valign="top">
                    <div><img src="/i/ico_2.png"></div>
                    <br>
                    <div>Следите за возможными<br> изменениями в правилах <br>проведения мероприятия!</div>
                </td>
                <td align="left" valign="top">
                    <div><img src="/i/ico_3.png"></div>
                    <br>
                    <div>При предъявлении льготного<br> билета удостоверение<br> студента обязательно!</div>
                </td>
                </tr>
                </table>
            </div>
            
            </body>
            </html>';


            $mpdf = new Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output($_SERVER["DOCUMENT_ROOT"].'/upload/pdf/tikets000'.$numberTikets.'.pdf');

            $mailSend['pdf'][]=$_SERVER["DOCUMENT_ROOT"].'/upload/pdf/tikets000'.$numberTikets.'.pdf';

            //$mpdf->Output();
            //echo $html;
            $arResult['PDF'][] = array('file'=>$_SERVER["DOCUMENT_ROOT"].'/upload/pdf/tikets000'.$numberTikets.'.pdf', 'user'=>$user);

            $i++;
        }


        $arResult['SEND_MAIL']= sendMailTikets($mailSend);

        if($arResult['SEND_MAIL']['SACCES']== 'Y'){
            mysqli_query($connect, "UPDATE customer SET send_ticket=1 WHERE id='".$id."' ");
        }


        return $arResult;
    }

}