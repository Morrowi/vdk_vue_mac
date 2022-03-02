<?php
require_once 'vendor/autoload.php';
require_once 'vendor/mpdf/mpdf/mpdf.php';
require_once 'libs/phpqrcode/qrlib.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/function.php';
global $connect;
$arResult =array();
if (isset($_GET['id'])){
    $id=__FilterInt($_GET['id']);

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
            break;
        case 'company_full_day':
        case 'private_full_day':
            $typeTicket='Стандартный';
            break;
        case 'private_stud_full_day':
            $typeTicket='Льготный для студентов до 23 лет';
            break;
    }



    $i=1;
    foreach ($arrUsers as $user){
    $numberTikets = $id.'_'.$i;

    $hash = base64_encode('ticket_'.$id.'_user_'.$user['id']); //dGlja2V0XzUwX3VzZXJfODY=

    QRcode::png('https://pay.karelforum.ru/check/?hash='.$hash.' ', __DIR__ . '/upload/qr/'.$numberTikets.'.png');


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
        <table width="100%">
        <tr>
        <td align="left">
            <div style="font-size: 21px; font-weight:bold;">
            Тип: '.$typeTicket.'
             <br>
            Дата: '.$dateDef.'
            </div>
            <br>
            <div style="font-size: 18px;">
                Участники:
                <br>
                '.$user["last_name"].' '.$user["name"].' '.$user["second_name"].'
            </div>
            <br>
            <br>
            <div style="font-size: 21px; font-weight: bold;">
            Россия, Республика Карелия, <br> Петрозаводск, Шуйское шоссе, 13
            </div>
        </td>
        <td align="right"><div><img src="https://pay.karelforum.ru/upload/qr/'.$numberTikets.'.png"></div></td>
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
    $i++;
    }
    $arResult['SEND_MAIL']= sendMailTikets($mailSend);

    if($arResult['SEND_MAIL']['SACCES']== 'Y'){
        mysqli_query($connect, "UPDATE customer SET send_ticket=1 WHERE id='".$id."' ");
    }


    echo json_encode($arResult, true);
}