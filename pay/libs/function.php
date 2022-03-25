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
        return$arResult;
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

    $merchantId = '12264';

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

    $url = 'https://beta-ecom.payment-guide.ru/api/e-commerce/v1/initSession';

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


    $merchantId = '12264';

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

    $url = 'https://beta-ecom.payment-guide.ru/api/e-commerce/v1/paymentStatus';

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
            //debug($ticket);
            //debug($arrUsers);
        } else {
            $arResult['ERROR']='Y';
            $arResult['ERROR_TEXT']='Текст не указан';
        }


        /*Инфа для отправки на почту*/
        $mailSend['email'] =  $ticket['email'];
        $mailSend['title'] = "Билеты на участие Карел Форум 2022";
        $mailSend['body'] =  "Выши билеты";



        $dateDef='16.05.2022 - 20.05.2022';

        //Тип
        switch ($ticket['what']){
            case 'private_one_day':
            case 'company_one_day':
                $typeTicket='Один день';
                $dateDef=$ticket['date'].'.2022';
                $mailSend['body'] =  "- доступ на форум в один из дней на выбор <br>
                                        - посещение лекций и круглых столов в выбранный день<br>
                                        - участие в мастер-классах в выбранный день <br>
                                        - экскурсии на карельские карьеры и заводы в выбранный день ";
                break;
            case 'company_full_day':
            case 'private_full_day':
                $typeTicket='Стандартный';
                $mailSend['body'] = "- доступ на форума на все дни <br>
                                - посещение лекций и круглых столов <br>
                                - участие в мастер-классах <br>
                                - экскурсии на карельские заводы и карьеры<br> 
                                - промокоды на скидку: <br>
                                на проживание в отелях Петрозаводска<br> 
                                 в сеть лучших рестаронов Петрозаводска<br>
                                на поездку в музей-заповедник Кижи<br>
                                на гала-ужин Карелфорума";
                break;
            case 'private_stud_full_day':
                $typeTicket='Льготный для студентов до 23 лет';
                $mailSend['body'] = "- посещение форума во все дни<br>
                                     - посещение лекций и круглых столах<br>
                                     - участие в мастер-классах<br>
                                     - выезды на карельские заводы и карьеры";
                break;
        }



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
                <td align="right"><div><img src="https://pay.karelforum.ru/i/ticket.png"></div></td>
                </tr>
                </table>
            </div>
            
            <table><tr><td height="20"></td></tr></table>    
            
            <div style="background: #FFFFFF; border: 1px solid #D7D7D7; border-radius: 20px 20px 0 0; padding: 20px 33px">
                <table width="100%">
                <tr>
                <td align="left"><div><img src="https://pay.karelforum.ru/i/logo_1.png"></div></td>
                <td align="center"><div><img src="https://pay.karelforum.ru/i/logo_2.png"></div></td>
                <td align="right"><div><img src="https://pay.karelforum.ru/i/logo_3.png"></div></td>
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
                                <td><img src="https://pay.karelforum.ru/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Доступ на форума на все дни</td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="https://pay.karelforum.ru/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Посещение лекций и круглых столов </td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="https://pay.karelforum.ru/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Участие в мастер-классах</td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="https://pay.karelforum.ru/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Экскурсии на карельские заводы и карьеры</td>
                            </tr>
                            <tr style="vertical-align:middle">
                                <td><img src="https://pay.karelforum.ru/i/dot.png" width="7" height="7"></td>
                                <td width="7"></td>
                                <td>Промокод на скидку на проживание в отелях Петрозаводска</td>
                            </tr>
                         </table>
                    </div>
                    <br>
                    <br>
                    <div style="font-size: 21px; font-weight: bold;">
                        Стоимость: <span style="color: #2F7135; font-weight: normal;">'.$price.' руб</span> 
                    </div>
                </td>
                <td align="right" valign="top"><div><img src="https://pay.karelforum.ru/upload/qr/'.$numberTikets.'.png"></div></td>
                </tr>
                </table>
            </div>
            
            <table><tr><td height="20"></td></tr></table>    
            
            <div style="background: #FFF3F3; border: 1px solid #FFF3F3; border-radius: 20px; padding: 20px 33px">
                <table width="100%">
                <tr>
                <td align="left" valign="top">
                    <div><img src="https://pay.karelforum.ru/i/ico_1.png"></div>
                    <br>
                    <div>Не забудьте средства <br> индивидуальной защиты!</div></td>
                <td align="left" valign="top">
                    <div><img src="https://pay.karelforum.ru/i/ico_2.png"></div>
                    <br>
                    <div>Следите за возможными<br> изменениями в правилах <br>проведения мероприятия!</div>
                </td>
                <td align="left" valign="top">
                    <div><img src="https://pay.karelforum.ru/i/ico_3.png"></div>
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