<?php
$root = dirname(__FILE__);
$request = $_SERVER['REQUEST_URI'];
$filename = basename($request);
$path =base64_decode($_GET['name']);
//echo $path;
$tmpname = explode('/',base64_decode($_GET['name']));
$filename= end($tmpname);
//var_dump($tmpname[3]);
//print '<pre>'; print_r($filename); print '</pre>';
//die();
print '<pre>'; print_r($path); print '</pre>';
//die();
if (file_exists($path)) {
    if (ob_get_level()) {
        ob_end_clean();
    }

    header("Content-Type: application/pdf; charset=UTF-8");
    header("Content-Length: ".filesize($path));
    header("Content-Disposition: attachment; filename=\"{$filename}\"");
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile($path);
}

//шифруем текст
//$text = '<a href="#">Ссылка</a>';
//echo base64_encode($text); //Выдаст: PGEgaHJlZj0iIyI+0KHRgdGL0LvQutCwPC9hPg==
//дешифровка
//echo base64_decode('PGEgaHJlZj0iIyI+0KHRgdGL0LvQutCwPC9hPg==');