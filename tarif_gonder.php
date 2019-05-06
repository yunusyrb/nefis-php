<?php 
include "sistem/ayar.php";
if (!isset($_SESSION["giris"])) {
	header("Location:index.php");
}
if ($_POST) {
	$baslik=@$_POST["baslik"];
	$kac_kisilik=@$_POST["kac_kisilik"];
	$hazirlanma_suresi=@$_POST["hazirlanma_suresi"];
	$pisirme_suresi=@$_POST["pisirme_suresi"];
	$malzemeler_detay=@$_POST["malzemeler_detay"];
	$hazirlanis_detay=@$_POST["hazirlanis_detay"];
	$kategori_id=@$_POST["kategori_id"];
	$yazar_id=$_SESSION["giris"];
	$kaynak = $_FILES["resim"]["tmp_name"]; // tempdeki adı
    $ad =  $_FILES["resim"]["name"]; // dosya adı
    $tip = $_FILES["resim"]["type"]; // dosya tipi
    $boyut = $_FILES["resim"]["size"]; // boyutu
    $hedef = "resimler"; // başta açtıgımız klasör adımız..
    $kaydet = move_uploaded_file($kaynak,$hedef."/".$ad); // resmimizi klasöre kayıt ettiriyoruz
	$resim=$hedef."/".$ad;
	$ekle=$db->prepare("INSERT INTO tarifler (baslik,kac_kisilik,hazirlanma_suresi,pisirme_suresi,malzemeler_detay,hazirlanis_detay,kategori_id,uye_id,resim) VALUES (?,?,?,?,?,?,?,?,?)")->execute(array($baslik,$kac_kisilik,$hazirlanma_suresi,$pisirme_suresi,$malzemeler_detay,$hazirlanis_detay,$kategori_id,$yazar_id,$resim));
	if ($ekle) {
		header("Location:tarif_detay.php?id=".$db->lastInsertId());
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
					echo '<a href="profil_guncelleme.php" class="button-style">Profil</a>';
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
		<form action="tarif_gonder.php" method="POST" enctype="multipart/form-data"	>
		<div class="recipies" style="padding: 30px">
			<div class="tarif-adi">
				<p>Tarif Adı</p>
				<input type="text" name="baslik" required>			
			</div>
			<div class="kac_kisilik">
				<p>Kaç Kişilik</p>
				<select name="kac_kisilik">
					<option>1-2 kişilik</option>
					<option>2-4 kişilik</option>
					<option>4-6 kişilik</option>
					<option>8-10 kişilik</option>
				</select>	
		
			</div>
			<div class="hazirlanma_suresi">
				<p>Hazırlanma Süresi</p>
				<select name="hazirlanma_suresi" >
					<option>5 dk</option>
					<option>15 dk</option>
					<option>30 dk</option>
					<option>45 dk</option>
				</select>					
						
			</div>
			<div class="pisirme_suresi">
				<p>Pişirme Süresi</p>
				<select  name="pisirme_suresi">	
					<option>15 dk</option>
					<option>30 dk</option>
					<option>45 dk</option>
					<option>60 dk</option>
					<option>90 dk</option>
					<option>120 dk</option>
				</select>			
			</div>
			<div class="malzemeler">
				<p>Malzemeler</p>
				<textarea name="malzemeler_detay"  cols="50" rows="15"></textarea>		
			</div>
			<div class="hazirlanis">
				<p>Hazırlanış</p>
				<textarea name="hazirlanis_detay"  cols="75" rows="15"></textarea>		
			</div>
				<div class="kategori-sec">
				<p>Kategoriler</p>
				<select name="kategori_id">
				<?php 
					$kategoriler=$db->query("SELECT * FROM 	kategoriler",PDO::FETCH_ASSOC);
					if ($kategoriler->rowCount()) {
						foreach ($kategoriler as $kategori) {
							echo '<option value="'.$kategori["kat_id"].'">'.$kategori["kat_isim"].'</option>';
						}
					}
				?>
				</select>			
			</div>
			<div>
				<p>Resim Ekle</p>
				<input type="file" name="resim">

			</div>
			<div>
			</br>	
				<input type="submit" name="kaydet"  value="KAYDET">
            	<input type="reset" name="sil"  value="TEMİZLE">	
			</div>
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