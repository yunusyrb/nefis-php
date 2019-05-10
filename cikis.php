<?php 
include "sistem/ayar.php";
unset($_SESSION["giris"]);
unset($_COOKIE["eposta"]);
unset($_COOKIE["sifre"]);
setcookie("eposta", "", time()-3600);
setcookie("sifre", "", time()-3600);
session_destroy();
header("Location:index.php");
?>