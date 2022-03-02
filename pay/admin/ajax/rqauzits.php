<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/function.php';
global $connect;
//AdmiNKarel22
$id =!empty($_POST['id'])?__FilterInt($_POST['id']):'';

if(!empty($id) OR $id>0){
    $query = mysqli_query($connect,"SELECT * FROM customer  WHERE id = '".$id."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    //debug($data);
    ?>
    <table class="table align-items-center mb-0">
        <tbody>
        <tr><td>Название организации: </td><td><?=$data['name_organiz']?></td></tr>
        <tr><td>Директор: </td><td><?=$data['gen_dir']?></td></tr>
        <tr><td>ИНН: </td><td><?=$data['inn']?></td></tr>
        <tr><td>ОГРН: </td><td><?=$data['ogrn']?></td></tr>
        <tr><td>БИК: </td><td><?=$data['bik']?></td></tr>
        <tr><td>КПП: </td><td><?=$data['kpp']?></td></tr>
        <tr><td>К/С: </td><td><?=$data['kor_schet']?></td></tr>
        <tr><td>Р/С: </td><td><?=$data['rascetni_schet']?></td></tr>
        </tbody>
    </table>
<?} else {
    echo 'Ошибка';
}?>
