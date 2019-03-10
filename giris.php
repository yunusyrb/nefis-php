<?php 
include "sistem/ayar.php";
if (isset($_SESSION["giris"])) {
	header("Location:index.php");

}
if ($_POST) {
	$eposta=@$_POST["eposta"];
	$sifre=@$_POST["sifre"];
	$kontrol=$db->query("SELECT * FROM uyeler WHERE eposta='{$eposta}' AND sifre='{$sifre}'" )->fetch(PDO::FETCH_ASSOC);
	if ($kontrol) {
		$_SESSION["giris"]=$kontrol["uye_id"];
		header("Location:index.php");
	}
	else{
		$hata="eposta veya şifre hatalı";
	}
}	

?>
<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Nefis Yemek Tarifleri</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<!--Başlık-->
	<header>
		<p><b>Nefis Yemek Tarifleri</b>, en çok okunan yemek tarifi paylaşım sitesi. Üye ol, tariflerini paylaş.</p>

		<div class="login-button">
			<?php
				if (isset($_SESSION["giris"])) {
					echo '<a href="cikis.php" class="button-style">Çıkış Yap</a>';
				}
				else{
					echo '<a href="giris.php" class="button-style">Giriş Yap</a>';
					echo '<a href="kayit.php" class="button-style">Kayıt Ol</a>';	
				}
			?>
			
		</div>
	</header>

	<!--Arama Kutusu-->
	<section class="header-out">
		<div class="group">
			<img src="img/logo.jpg" alt="Nefis Yemek Tarifleri" height="100" width="100">

			<div class="search-group">
				<form action="" method="POST">
					<input type="text" name="search-input" placeholder="Hangi tarifi istersin?" class="search-input" />
					<input type="submit" name="search-button" class="search-button" value="Ara" />
				</form>
			</div>

			<a href="tarif_gonder.php" class="send-tariffs-button">Tarif Gönder</a>
		</div>
	</section>
	
	<!--Menüler-->
	<section class="menu-group">
		<div class="flex-group">
			<a href="index.php" class="menu">Anasayfa</a>
			<?php 
				$kategoriler=$db->query("SELECT * FROM 	kategoriler",PDO::FETCH_ASSOC);
				if ($kategoriler->rowCount()) {
					foreach ($kategoriler as $kategori) {
						echo '<a href="kategori.php?id='.$kategori["kat_id"].'" class="menu">'.$kategori["kat_isim"].'</a>';
					}
				}
			 ?>
		</div>
	</section>

	<!--İçerik-->
	<section class="content bg">
		<form action="giris.php" method="POST" >
		<div class="recipies" style="padding: 30px">
			<div class="giri-kullanici-ad">
				<p>E-posta</p>
				<input type="text" name="eposta"  required>			
			</div>
			<div class="giris-sifre">
			</br>	
				<p>Şifre</p>
				<input type="password" name="sifre" required>
				<input type="submit" name="kaydet" id="kaydet" value="Giriş Yap">	
			</div>
			<br>
			<?php 
				if (isset($hata)) {
					echo $hata;
				}
			 ?>
		</form>
		</div>
		
	</section>
		

	<footer>
		<img src="img/footer-logo.png" alt="" height="80" width="80" class="footer-logo">
		<div class="mind">
			<p class="footer-copyright-text">Her hakkı saklıdır. © 2007-2019 Nefis Yemek Tarifleri</p>
		</div>
	</footer>
</body>
</html>