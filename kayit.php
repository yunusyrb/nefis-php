<?php 
include "sistem/ayar.php";
if (isset($_SESSION["giris"])) {
	header("Location:index.php");

}
if ($_POST) {
	$eposta=@$_POST["eposta"];
	$sifre=@$_POST["sifre"];
	$sifretekrar=@$_POST["sifretekrar"];
	$adsoyad=@$_POST["adsoyad"];
	$cinsiyet=@$_POST["cinsiyet"];
	$kullaniciadi=@$_POST["kullaniciadi"];
	if ($sifre==$sifretekrar) {
		if ( !empty($eposta) && !empty($sifre)  && !empty($sifretekrar)  && !empty($adsoyad) && !empty($cinsiyet) && !empty($kullaniciadi) ) {
				$ekle=$db->prepare("INSERT INTO uyeler (eposta,isim,sifre,cinsiyet,kullanici_adi) VALUES (?,?,?,?,?)")->execute(array($eposta,$sifre,$adsoyad,$cinsiyet,$kullaniciadi));
				if ($ekle) {
					$_SESSION["giris"]=$db->lastInsertId();
					header("Location:index.php");

				}
				else{
					$hata="kayıt eklenemedi.";
				}
		}
		else{
			$hata="boş bırakmayın.";
		}
	}
	else{
		$hata="şifreler uyuşmuyor";
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
				<form action="ara.php" method="GET">
					<input type="text" name="s" placeholder="Hangi tarifi istersin?" class="search-input" />
					<input type="submit" class="search-button" value="Ara" />
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
		<form action="kayit.php" method="POST"  >
		<div class="recipies" style="padding: 30px">
			<div class="kayit-mail">
				<p>E-mail Adresi</p>
				<input type="text" name="eposta"  required>			
			</div>
			<div class="kayit-sifre">
				<p>Şifre</p>
				<input type="text" name="sifre"  required>			
			</div>
			<div class="kayit-sifre-tekrar">
				<p>Şifre Tekrar Giriniz</p>
				<input type="text" name="sifretekrar"  required>			
			</div>
			<div class="ad-soyad">
				<p>Ad Soyad</p>
				<input type="text" name="adsoyad"  required>			
			</div>
			
			<div class="cinsiyet">
				<p>Cinsiyet</p>
				<input type="radio" name="cinsiyet" id="cinsiyet" value="K" checked>Kadın </br>
              	<input type="radio" name="cinsiyet" id="cinsiyet1" value="E">  Erkek
			</div>
			<div class="kayit-kullanici-ad">
				<p>Kullanıcı Adı</p>
				<input type="text" name="kullaniciadi"  required>			
			</div>
			<div>
			</br>
				<input type="submit" name="kaydet" id="kaydet" value="Kayıt">	
			</div>
		</form>
		</div>
		<?php 
			if (isset($hata)) {
				echo $hata;
			}
		?>
		
	</section>
		

	<footer>
		<img src="img/footer-logo.png" alt="" height="80" width="80" class="footer-logo">
		<div class="mind">
			<p class="footer-copyright-text">Her hakkı saklıdır. © 2007-2019 Nefis Yemek Tarifleri</p>
		</div>
	</footer>
</body>
</html>