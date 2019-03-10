<?php 
include "sistem/ayar.php";
unset($_SESSION["giris"]);
session_destroy();
header("Location:index.php");
?>