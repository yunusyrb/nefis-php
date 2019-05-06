<?php 

include "sistem/ayar.php";

$uye_id = $_SESSION["giris"];
$uye = $db->query("SELECT * FROM uyeler WHERE uye_id = '{$uye_id}'")->fetch(PDO::FETCH_ASSOC);

if(isset($_POST)) {
	$email = @$_POST["eposta"];
	$sifre = @$_POST["sifre"];
	$isim = @$_POST["adsoyad"];
	$kullanici_adi = @$_POST["kullaniciadi"];

	if($uye["sifre"] == $sifre) {
	 	$query = $db->prepare("UPDATE uyeler SET eposta = ?, isim = ?, kullanici_adi = ? WHERE uye_id = ?");
    	$update = $query->execute(array(
      		$email, $isim, $kullanici_adi, $uye_id
    	));
    	if($update) {
    		$mesaj = "Güncelleme işlemi başarılı";
    		$uye = $db->query("SELECT * FROM uyeler WHERE uye_id = '{$uye_id}'")->fetch(PDO::FETCH_ASSOC);
    	} else {
    		$mesaj = "Güncelleme işlemi yapılamadı.";
    	}
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
		<form action="profil_guncelleme.php" method="POST">
		<div class="recipies" style="padding: 30px">
			<div class="kayit-mail">
				<p>E-mail Adresi</p>
				<input type="text" name="eposta" value="<?php echo $uye["eposta"]; ?>" required>			
			</div>
			<div class="kayit-sifre">
				<p>Şifre</p>
				<input type="password" name="sifre" required>			
			</div>
			<div class="ad-soyad">
				<p>Ad Soyad</p>
				<input type="text" name="adsoyad" value="<?php echo $uye["isim"]; ?>" required>			
			</div>
			
			<div class="kayit-kullanici-ad">
				<p>Kullanıcı Adı</p>
				<input type="text" name="kullaniciadi" value="<?php echo $uye["kullanici_adi"]; ?>" required>			
			</div>
			<div class="mesaj">
				<?php 
					if(isset($mesaj)){ echo $mesaj; }
				?>
			</div>	
			<div>
			</br>
				<input type="submit" name="kaydet" id="kaydet" value="Güncelle">	
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