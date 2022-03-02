<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/function.php';
global $connect;

$id =!empty($_POST['id'])?__FilterInt($_POST['id']):'';

if(!empty($id) OR $id>0){
    $query = mysqli_query($connect,"SELECT * FROM customer  WHERE id = '".$id."' LIMIT 1");
    $customer = mysqli_fetch_assoc($query);
    //debug($data);
    ?>

        <td>
            <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['id']?></p>
        </td>
        <td>
            <?
            $users = json_decode($customer['user']);
            $ids = join("','",$users);
            $users = mysqli_query($connect,"SELECT * FROM users  WHERE id IN ('$ids')");


            ?>
            <div class="d-flex px-2 py-1">
                <div class="d-flex flex-column justify-content-center">
                    <?
                    while ($user = $customers = mysqli_fetch_assoc($users)){
                        unset($user['id'],$user['customer']);
                        ?>
                        <h6 class="mb-0 text-xs"><?echo  implode(' ', $user)?></h6>
                    <?}?>
                </div>
            </div>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['phone']?></p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['email']?></p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center">
                <?
                switch ( $customer['what']){
                    case 'company_one_day':
                    case 'company_full_day':
                        echo '<a href="javascript:;" onclick="showRequzit('.$customer['id'].');" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Выслать билет">'.$customer['name_organiz'].'</a>';
                        break;
                    default:
                        echo '-';
                        break;
                }
                ?>

            </p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['date']?></p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center">
                <?
                switch ( $customer['what']){
                    case 'company_one_day':
                        echo 'Ю. день';
                        break;
                    case 'company_full_day':
                        echo 'Ю. вce день';
                        break;
                    case 'private_one_day':
                        echo 'Ф. один день';
                        break;
                    case 'private_full_day':
                        echo 'Ф. все дни';
                        break;
                    case 'private_stud_full_day':
                        echo 'Студ.';
                        break;
                }
                ?>
            </p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['price']?></p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center"><?=$customer['promo']?></p>
        </td>
        <td>
            <?if($customer['paymend']==0){?>
                <p class="text-xs font-weight-bold mb-0 text-center">Нет</p>
                <p class="text-xs text-secondary mb-0 text-center"><a href="javascript:;" onclick="paymend(<?=$customer['id']?>);" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Выслать билет">Оплачен</a></p>
            <?}else{?>
                <p class="text-xs text-secondary mb-0 text-center">Да</p>
            <?}?>

        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0 text-center">
                <?=($customer['send_ticket']==0)?'<a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Выслать билет">Выслать</a>':'Отправлен'?>
            </p>
        </td>
<?} else {
    echo 'Ошибка';
}?>
