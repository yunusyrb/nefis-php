<?php 
try {
	$db=new PDO("mysql:host=localhost;dbname=nefis;charset=utf8","root","");
} catch (PDOException $e) {
	die("veritabanına bağlanamadı.");
}
session_start();
 ?>