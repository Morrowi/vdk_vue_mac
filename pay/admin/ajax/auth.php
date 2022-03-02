<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/libs/function.php';
global $connect;
//AdmiNKarel22
$login =!empty($_POST['login'])?__FilterText($_POST['login']):'';
$password =!empty($_POST['password'])?__FilterText($_POST['password']):'';


$arResult=array();

if(!empty($login) OR !empty($password)){

    $query = mysqli_query($connect,"SELECT id, password FROM user WHERE login='".$login."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if($data['password'] === md5($password)){
        $hash = md5(generateCode(10));
        mysqli_query($connect,"UPDATE user SET hash='".$hash."' ");
        setcookie("id", $data['id'], time()+60*60*24*30, '/');
        setcookie("hash", $hash, time()+60*60*24*30, '/');
        $arResult['SACCES']='Y';
    }else{
        $arResult['error']="Вы ввели неправильный логин/пароль";
    }

}

echo json_encode($arResult, true);

//echo'<pre>';print_r($arResult);echo'</pre>';