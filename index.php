<?php 
include "sistem/ayar.php";

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

			<button class="send-tariffs-button">Tarif Gönder</button>
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
		<div class="recipies">
			<div class="recipe-title">
				<p>Takip Ettiklerinizden Yeni Tarifler</p>
				<a href="#">Daha fazla yazar takip et</a>
			</div>

			<div class="welcome-title">
				<p>Türkiye'nin en çok okunan ve paylaşılan yemek tarifleri topluluğuna hoşgeldiniz</p>
				<p>Yazar takip etme özelliğiyle takip ettiğiniz yazarların tariflerini öncelikli olarak görebilirsiniz.
Takip etme işleminden sonra buraya tıklayarak sayfayı yenileyerek tarifleri görebilirsiniz..</p>
			</div>

			<div class="follow">
				

				
			</div>
		</div>
		
		<div class="categories">
			<p>Kategoriler</p>
			
			<?php 
				$kategoriler=$db->query("SELECT * FROM 	kategoriler",PDO::FETCH_ASSOC);
				if ($kategoriler->rowCount()) {
					foreach ($kategoriler as $kategori) {
						echo '<div class="category-menu"><a href="kategori.php?id='.$kategori["kat_id"].'">'.$kategori["kat_isim"].'</a></div>';
					}
				}
			 ?>
		</div>
	</section>

	<section class="content bg">
		<div class="recipies">
			<div class="recipe-title">
				<p>Yeni Tarifler</p>
				<button class="all-see">Sen de Tarif Gönder</button>
			</div>
			
			<div class="new-recipies">
				<?php 
					$tarifler=$db->query("SELECT * FROM tarifler ORDER BY tarif_id DESC LIMIT 8",PDO::FETCH_ASSOC);
					if ($tarifler->rowCount()) {
						foreach ($tarifler as $tarif) {
								echo '<div class="new-recipe">
						<a href="tarif_detay.php?id='.$tarif["tarif_id"].'"><img src="'.$tarif["resim"].'" alt="" height="80" width="120"></a>
						<div class="recipe-description">
							<p>'.$tarif["baslik"].'</p>
							
						</div>
					</div>';
						}
					}
				 ?>
			</div>
			<div class="all-see-group">
				<button class="all-see">Tamamını Göster</button>
			</div>
			
		</div>
		
		
	</section>
	
	<section class="content bg">
		<div class="recipies">
			<div class="recipe-title">
				<p>Popülerler</p>
			</div>
			
			<div class="new-recipies">
				<?php 
					$tarifler=$db->query("SELECT * FROM tarifler ORDER BY okunma DESC LIMIT 8",PDO::FETCH_ASSOC);
					if ($tarifler->rowCount()) {
						foreach ($tarifler as $tarif) {
								echo '<div class="new-recipe">
						<a href="tarif_detay.php?id='.$tarif["tarif_id"].'"><img src="'.$tarif["resim"].'" alt="" height="80" width="120"></a>
						<div class="recipe-description">
							<p>'.$tarif["baslik"].'</p>
							
						</div>
					</div>';
						}
					}
				 ?>
				
			</div>
			<div class="all-see-group">
				<button class="all-see">Tamamını Göster</button>
			</div>
			
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