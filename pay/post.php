<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/function.php';


global $connect;
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  exit(0);
}

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);




if(!empty($_POST)){
    switch ($_POST['what']){
        case 'company_one_day':
            $mail['title']='ЮР: Билет на один день форума';
            if(mysqli_query($connect, "INSERT INTO customer SET
                phone='". $_POST['phone']."',
                email='". $_POST['email'] . "',
                promo='". $_POST['promo'] . "',
                name_organiz='". $_POST['name_organiz'] . "',
                ogrn='". __FilterInt($_POST['ogrn']) . "',
                gen_dir='". $_POST['gen_dir'] . "',
                rascetni_schet='".__FilterInt ($_POST['rascetni_schet']) . "',
                inn='". __FilterInt($_POST['inn']) . "',
                bik='". __FilterInt($_POST['bik']) . "',
                kpp='". __FilterInt($_POST['kpp']) . "',
                kor_schet='". __FilterInt($_POST['kor_schet']) . "',
                soglasie='". $_POST['soglasie'] . "',
                date='". $_POST['date'] . "',
                what='". $_POST['what'] . "',
                price='". __FilterInt($_POST['price']) . "'
                ")){
                $customer_id = mysqli_insert_id($connect);

                if($customer_id>0){
                    $arrUsersId=array();
                    foreach ($_POST['user'] as $user){
                        mysqli_query($connect, "INSERT INTO users SET
                            customer='". $customer_id."',
                            name='". $user['name'] . "',
                            last_name='". $user['last_name'] . "',
                            second_name='". $user['second_name'] . "'
                            ");
                        $arrUsersId[]=mysqli_insert_id($connect);
                    }
                    $user = json_encode($arrUsersId);
                    mysqli_query($connect, "UPDATE customer SET user='" .$user. "' WHERE id='".$customer_id."' ");
                    echo'<pre>';print_r($arrUsersId);echo'</pre>';

                    $mail['body']=
                        '<table>
                         <tr>
                            <td>ID билета</td>
                            <td>'.$customer_id.'</td>
                         </tr>
                         <tr>
                            <td>Дату посещения</td>
                            <td>'.$_POST['date'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Реквизиты</b></td>
                         </tr>
                         <tr>
                            <td>Название организации</td>
                            <td>'.$_POST['name_organiz'].'</td>
                         </tr>
                         <tr>
                            <td>Ген. Директор</td>
                            <td>'.$_POST['gen_dir'].'</td>
                         </tr>
                         <tr>
                            <td>ОГРН</td>
                            <td>'.$_POST['ogrn'].'</td>
                         </tr>
                         <tr>
                            <td>Р/с</td>
                            <td>'.$_POST['rascetni_schet'].'</td>
                         </tr>
                         <tr>
                            <td>ИНН</td>
                            <td>'.$_POST['inn'].'</td>
                         </tr>
                         <tr>
                            <td>БИК</td>
                            <td>'.$_POST['bik'].'</td>
                         </tr>
                         <tr>
                            <td>КПП</td>
                            <td>'.$_POST['kpp'].'</td>
                         </tr>
                         <tr>
                            <td>Корп. счет</td>
                            <td>'.$_POST['kor_schet'].'</td>
                         </tr>
                         <tr>
                            <td>Ген. Директор</td>
                            <td>'.$_POST['gen_dir'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Контакты</b></td>
                         </tr>
                         <tr>
                            <td>Телефон</td>
                            <td>'.$_POST['phone'].'</td>
                         </tr>
                         <tr>
                            <td>Email</td>
                            <td>'.$_POST['email'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Участники</b></td>
                         </tr>';

                        foreach ($_POST['user'] as $user){
                            $mail['body'].='<tr><td>'.implode(' ',$user).'</td></tr>';
                        }
                        $mail['body'].='</table>';
                        //$result = sendMail($mail);
                        //echo'<pre>';print_r($result);echo'</pre>';
                }
            }
            break;


        case 'company_full_day':
            $mail['title']='ЮР: Билет на все дени форума';
            echo'<pre>';print_r($_POST);echo'</pre>';
            if($res = mysqli_query($connect, "INSERT INTO customer SET
                phone='". $_POST['phone']."',
                email='". $_POST['email'] . "',
                promo='". $_POST['promo'] . "',
                name_organiz='". $_POST['name_organiz'] . "',
                ogrn='". __FilterInt($_POST['ogrn']) . "',
                gen_dir='". $_POST['gen_dir'] . "',
                rascetni_schet='".__FilterInt ($_POST['rascetni_schet']) . "',
                inn='". __FilterInt($_POST['inn']) . "',
                bik='". __FilterInt($_POST['bik']) . "',
                kpp='". __FilterInt($_POST['kpp']) . "',
                kor_schet='". __FilterInt($_POST['kor_schet']) . "',
                soglasie='". $_POST['soglasie'] . "',
                date='". $_POST['date'] . "',
                what='". $_POST['what'] . "',
                price='". __FilterInt($_POST['price']) . "'
                ")){
                $customer_id = mysqli_insert_id($connect);

                if($customer_id>0){
                    $arrUsersId=array();
                    foreach ($_POST['user'] as $user){
                        mysqli_query($connect, "INSERT INTO users SET
                            customer='". $customer_id."',
                            name='". $user['name'] . "',
                            last_name='". $user['last_name'] . "',
                            second_name='". $user['second_name'] . "'
                            ");
                        $arrUsersId[]=mysqli_insert_id($connect);
                    }
                    $user = json_encode($arrUsersId);
                    mysqli_query($connect, "UPDATE customer SET user='" .$user. "' WHERE id='".$customer_id."' ");
                    echo'<pre>';print_r($arrUsersId);echo'</pre>';

                    $mail['body']=
                        '<table>
                         <tr>
                            <td>ID билета</td>
                            <td>'.$customer_id.'</td>
                         </tr>
                         <tr>
                            <td>Дату посещения</td>
                            <td>'.$_POST['date'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Реквизиты</b></td>
                         </tr>
                         <tr>
                            <td>Название организации</td>
                            <td>'.$_POST['name_organiz'].'</td>
                         </tr>
                         <tr>
                            <td>Ген. Директор</td>
                            <td>'.$_POST['gen_dir'].'</td>
                         </tr>
                         <tr>
                            <td>ОГРН</td>
                            <td>'.$_POST['ogrn'].'</td>
                         </tr>
                         <tr>
                            <td>Р/с</td>
                            <td>'.$_POST['rascetni_schet'].'</td>
                         </tr>
                         <tr>
                            <td>ИНН</td>
                            <td>'.$_POST['inn'].'</td>
                         </tr>
                         <tr>
                            <td>БИК</td>
                            <td>'.$_POST['bik'].'</td>
                         </tr>
                         <tr>
                            <td>КПП</td>
                            <td>'.$_POST['kpp'].'</td>
                         </tr>
                         <tr>
                            <td>Корп. счет</td>
                            <td>'.$_POST['kor_schet'].'</td>
                         </tr>
                         <tr>
                            <td>Ген. Директор</td>
                            <td>'.$_POST['gen_dir'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Контакты</b></td>
                         </tr>
                         <tr>
                            <td>Телефон</td>
                            <td>'.$_POST['phone'].'</td>
                         </tr>
                         <tr>
                            <td>Email</td>
                            <td>'.$_POST['email'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Участники</b></td>
                         </tr>';

                    foreach ($_POST['user'] as $user){
                        $mail['body'].='<tr><td>'.implode(' ',$user).'</td></tr>';
                    }
                    $mail['body'].='</table>';
                    //$result = sendMail($mail);
                    //echo'<pre>';print_r($result);echo'</pre>';
                }
            }
            echo mysqli_error($res);
            break;

        case 'private_one_day':
            $mail['title']='Физ: Билет на один день форума';
            echo'<pre>';print_r($_POST);echo'</pre>';
            if($res = mysqli_query($connect, "INSERT INTO customer SET
                phone='". $_POST['phone']."',
                email='". $_POST['email'] . "',
                promo='". $_POST['promo'] . "',
                date='". $_POST['date'] . "',
                what='". $_POST['what'] . "',
                price='". __FilterInt($_POST['price']) . "'
                ")){
                $customer_id = mysqli_insert_id($connect);

                if($customer_id>0){
                    $arrUsersId=array();
                    foreach ($_POST['user'] as $user){
                        mysqli_query($connect, "INSERT INTO users SET
                            customer='". $customer_id."',
                            name='". $user['name'] . "',
                            last_name='". $user['last_name'] . "',
                            second_name='". $user['second_name'] . "'
                            ");
                        $arrUsersId[]=mysqli_insert_id($connect);
                    }
                    $user = json_encode($arrUsersId);
                    mysqli_query($connect, "UPDATE customer SET user='" .$user. "' WHERE id='".$customer_id."' ");
                    echo'<pre>';print_r($arrUsersId);echo'</pre>';

                    $mail['body']=
                        '<table>
                         <tr>
                            <td>ID билета</td>
                            <td>'.$customer_id.'</td>
                         </tr>
                         <tr>
                            <td>Дату посещения</td>
                            <td>'.$_POST['date'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Контакты</b></td>
                         </tr>
                         <tr>
                            <td>Телефон</td>
                            <td>'.$_POST['phone'].'</td>
                         </tr>
                         <tr>
                            <td>Email</td>
                            <td>'.$_POST['email'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Участники</b></td>
                         </tr>';

                    foreach ($_POST['user'] as $user){
                        $mail['body'].='<tr><td>'.implode(' ',$user).'</td></tr>';
                    }
                    $mail['body'].='</table>';
                    //$result = sendMail($mail);
                    //echo'<pre>';print_r($result);echo'</pre>';
                }
            }
            echo mysqli_error($res);
            break;

        case 'private_full_day':
            $mail['title']='Физ: Билет на все дени форума';
            echo'<pre>';print_r($_POST);echo'</pre>';
            if($res = mysqli_query($connect, "INSERT INTO customer SET
                phone='". $_POST['phone']."',
                email='". $_POST['email'] . "',
                promo='". $_POST['promo'] . "',
                date='". $_POST['date'] . "',
                what='". $_POST['what'] . "',
                price='". __FilterInt($_POST['price']) . "'
                ")){
                $customer_id = mysqli_insert_id($connect);

                if($customer_id>0){
                    $arrUsersId=array();
                    foreach ($_POST['user'] as $user){
                        mysqli_query($connect, "INSERT INTO users SET
                            customer='". $customer_id."',
                            name='". $user['name'] . "',
                            last_name='". $user['last_name'] . "',
                            second_name='". $user['second_name'] . "'
                            ");
                        $arrUsersId[]=mysqli_insert_id($connect);
                    }
                    $user = json_encode($arrUsersId);
                    mysqli_query($connect, "UPDATE customer SET user='" .$user. "' WHERE id='".$customer_id."' ");
                    echo'<pre>';print_r($arrUsersId);echo'</pre>';

                    $mail['body']=
                        '<table>
                         <tr>
                            <td>ID билета</td>
                            <td>'.$customer_id.'</td>
                         </tr>
                         <tr>
                            <td>Дату посещения</td>
                            <td>'.$_POST['date'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Контакты</b></td>
                         </tr>
                         <tr>
                            <td>Телефон</td>
                            <td>'.$_POST['phone'].'</td>
                         </tr>
                         <tr>
                            <td>Email</td>
                            <td>'.$_POST['email'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Участники</b></td>
                         </tr>';

                    foreach ($_POST['user'] as $user){
                        $mail['body'].='<tr><td>'.implode(' ',$user).'</td></tr>';
                    }
                    $mail['body'].='</table>';
                    //$result = sendMail($mail);
                    //echo'<pre>';print_r($result);echo'</pre>';
                }
            }
            echo mysqli_error($res);
            break;

        case 'private_stud_full_day':
            $mail['title']='Студент: Билет на все дени форума';
            echo'<pre>';print_r($_POST);echo'</pre>';
            if($res = mysqli_query($connect, "INSERT INTO customer SET
                phone='". $_POST['phone']."',
                email='". $_POST['email'] . "',
                promo='". $_POST['promo'] . "',
                date='full',
                what='". $_POST['what'] . "',
                price='". __FilterInt($_POST['price']) . "'
                ")){
                $customer_id = mysqli_insert_id($connect);

                if($customer_id>0){
                    $arrUsersId=array();
                    foreach ($_POST['user'] as $user){
                        mysqli_query($connect, "INSERT INTO users SET
                            customer='". $customer_id."',
                            name='". $user['name'] . "',
                            last_name='". $user['last_name'] . "',
                            second_name='". $user['second_name'] . "'
                            ");
                        $arrUsersId[]=mysqli_insert_id($connect);
                    }
                    $user = json_encode($arrUsersId);
                    mysqli_query($connect, "UPDATE customer SET user='" .$user. "' WHERE id='".$customer_id."' ");
                    echo'<pre>';print_r($arrUsersId);echo'</pre>';

                    $mail['body']=
                        '<table>
                         <tr>
                            <td>ID билета</td>
                            <td>'.$customer_id.'</td>
                         </tr>
                         <tr>
                            <td>Дату посещения</td>
                            <td>'.$_POST['date'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Контакты</b></td>
                         </tr>
                         <tr>
                            <td>Телефон</td>
                            <td>'.$_POST['phone'].'</td>
                         </tr>
                         <tr>
                            <td>Email</td>
                            <td>'.$_POST['email'].'</td>
                         </tr>
                         <tr>
                            <td colspan="2"><b>Участники</b></td>
                         </tr>';

                    foreach ($_POST['user'] as $user){
                        $mail['body'].='<tr><td>'.implode(' ',$user).'</td></tr>';
                    }
                    $mail['body'].='</table>';
                    //$result = sendMail($mail);
                    //echo'<pre>';print_r($result);echo'</pre>';
                }
            }
            echo mysqli_error($res);
            break;
    }



}



/*
INSERT INTO `customer`(`id`, `user`, `phone`, `email`, `promo`, `name_organiz`, `ogrn`, `gen_dir`, `rascetni_schet`, `inn`, `bik`, `kpp`, `kor_schet`, `soglasie`, `date`, `what`, `price`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]')
*/