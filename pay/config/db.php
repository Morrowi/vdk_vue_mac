<?
$host='localhost';
$db='147946_karelforum';
$user='147946';
$password='sUuEF1fgPa';
$connect=mysqli_connect($host,$user,$password,$db) or die('REDZ: Error connect to database!');
mysqli_query($connect,"SET NAMES utf8");