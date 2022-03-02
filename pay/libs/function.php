<?php
include $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/PHPMailer.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/SMTP.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/Exception.php';

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



    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        // Параметры SMTP-сервера
        //$mail->SMTPDebug = 2;                                 // Раскомментируйте для вывода отладочной информации
        $mail->isSMTP();                                        // Указываем, что модуль будет работать в режиме SMTP
        $mail->Host = 'smtp.yandex.ru';                         // Адрес сервера SMTP
        $mail->SMTPAuth = true;                                 // Включение аутентификации SMTP
        $mail->Username = 'em@redz.ru';                         // Адрес полностью, если используется почта для домена.
        $mail->Password = 'SaN-SaI123';
        $mail->SMTPSecure = 'ssl';                              // Включение шифрования TLS, как вариант можно 'ssl'
        $mail->Port = 465;                                      // TCP-порт, для Яндекса работает именно такой


        // Получатели
        $mail->setFrom('em@redz.ru', 'Robot');        // Отправитель
        $mail->addAddress('morrowi@ya.ru', 'User Name');     // Добавление получателя, в таком виде можно указать несколько
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
        echo 'Письмо отправлено';

    } catch (Exception $e) {
        echo 'Не удалось отправить письмо.';
        echo 'Ошибка: ' . $mail->ErrorInfo;
    }




}



function sendMailTikets($data){



    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        // Параметры SMTP-сервера
        //$mail->SMTPDebug = 2;                                 // Раскомментируйте для вывода отладочной информации
        $mail->isSMTP();                                        // Указываем, что модуль будет работать в режиме SMTP
        $mail->Host = 'smtp.yandex.ru';                         // Адрес сервера SMTP
        $mail->SMTPAuth = true;                                 // Включение аутентификации SMTP
        $mail->Username = 'em@redz.ru';                         // Адрес полностью, если используется почта для домена.
        $mail->Password = 'SaN-SaI123';
        $mail->SMTPSecure = 'ssl';                              // Включение шифрования TLS, как вариант можно 'ssl'
        $mail->Port = 465;                                      // TCP-порт, для Яндекса работает именно такой


        // Получатели
        $mail->setFrom('em@redz.ru', 'Карел формум 2022');        // Отправитель
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
        return$arResult;
    } catch (Exception $e) {
        $arResult['EROOR'] = 'Не удалось отправить письмо.';
        $arResult['EROOR_TEXT']= 'Ошибка: ' . $mail->ErrorInfo;

        return $arResult;
    }




}
