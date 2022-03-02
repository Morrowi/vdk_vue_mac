<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/function.php';
global $connect;
$id =!empty($_POST['id'])?__FilterInt($_POST['id']):'';

if(!empty($id) OR $id>0){
    mysqli_query($connect, "UPDATE customer SET paymend=1 WHERE id='".$id."' ");

} else {
    echo 'Ошибка';
}?>
