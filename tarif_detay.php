<?php 
include "sistem/ayar.php";

if (isset($_GET["id"])) {
	$tarif_id=$_GET["id"];
	$kontrol=$db->query("SELECT * FROM tarifler WHERE tarif_id='{$tarif_id}'" )->fetch(PDO::FETCH_ASSOC);
	if (!$kontrol) {
		header("Location:index.php");
	}
}
else{
	header("Location:index.php");
}
$arttir=$db->prepare("UPDATE tarifler SET okunma=okunma+1 WHERE tarif_id={$tarif_id}")->execute();
if ($_POST) {
	if(isset($_POST["ust"])){
		$ust_id = @$_POST["ust"];
		$yorum = @$_POST["yorum"];
		$uye_id = $_SESSION["giris"];
		$tarif_id = $_GET["id"];
		$ekle = $db->prepare("INSERT INTO yorumlar (uye_id,tarif_id,ust_id,yorum) VALUES (?,?,?,?)")->execute(array($uye_id,$tarif_id,$ust_id,$yorum));
	}else{
		$yanit=$_POST["anket"];
		$ekle=$db->prepare("INSERT INTO anket (uye_id,tarif_id,yanit) VALUES (?,?,?)")->execute(array($_SESSION["giris"],$_GET["id"],$yanit));
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
		<div class="recipies" >
			<div class="follow" style="padding: 30px;">
				<div >
					<img src="<?php echo $kontrol["resim"]; ?>" style="max-width: 80% , height:auto;">
				</div>
				<div class="kullanici_bilgileri">
					<p><b>Yazar:</b> <?php 
					$uye_id=$kontrol['uye_id'];
					$sorgu=$db->query("SELECT * FROM uyeler WHERE uye_id={$uye_id}")->fetch(PDO::FETCH_ASSOC);
					echo $sorgu["isim"];
				 ?></p>
				</div>
				<h1><?php echo $kontrol["baslik"]; ?></h1>
				<p><?php echo $kontrol["kac_kisilik"]; ?></p>
				<p><?php echo $kontrol["hazirlanma_suresi"]; ?></p>
				<p><?php echo $kontrol["pisirme_suresi"]; ?></p>
				<p><?php echo $kontrol["malzemeler_detay"]; ?></p>
				<p><?php echo $kontrol["hazirlanis_detay"]; ?></p>
				<p><?php 
					$kat_id=$kontrol['kategori_id'];
					$sorgu=$db->query("SELECT * FROM kategoriler WHERE kat_id={$kat_id}")->fetch(PDO::FETCH_ASSOC);
					echo $sorgu["kat_isim"];
				 ?></p>
				 <?php if (isset($_SESSION["giris"])){ ?>
				<div class="anket" style="background: white; width: 500px; border: 1px solid red; padding: 15px;">
					<p>Bu tarif pratik mi? Kolayca pişirilebilir mi?</p>
					<form method="POST" action="tarif_detay.php?id=<?php echo $_GET["id"]; ?>">
						<?php
							$uye_id=$_SESSION["giris"];
							$tarif_id=$_GET["id"];
							$anket=$db->query("SELECT * FROM anket WHERE uye_id={$uye_id} AND tarif_id={$tarif_id}")->fetch(PDO::FETCH_ASSOC);
							if ($anket) {
								if ($anket["yanit"]==1) {
									echo "Bu ankete evet oyu kullandınız.";
									
								}
								else{
									echo "Bu ankete hayır oyu kullandınız";
								}
							}
							else{
								?>
								<input type="radio" name="anket"  value="1" checked>Evet <br>
			              		<input type="radio" name="anket"  value="0">  Hayır <br><br>
			              		<button type="submit">OYLA</button>
								<?php
							}

						?>
              		</form>
				</div>
				<?php } ?>
				
				<p style="font-size: 20px;font-weight: bold;text-decoration: underline;">Yorumlar</p>
				
				<?php if (isset($_SESSION["giris"])){ ?>
				<form method="post" action="tarif_detay.php?id=<?php echo $_GET["id"]; ?>">
					<input type="hidden" name="ust" value="0">
					<textarea name="yorum" cols="75" rows="8"></textarea>		
					<input type="submit" id="yorum_ekle" value="Yorum Gönder">
				</form>
				<?php } ?>
				
				<div class="yorum">
					<?php
						$tarif_id=$_GET["id"]; 
						$yorumlar=$db->query("SELECT * FROM yorumlar WHERE tarif_id={$tarif_id} AND ust_id=0",(PDO::FETCH_ASSOC));
						if ($yorumlar->rowCount()) {
							foreach ($yorumlar as $yorum ) {
								$ust_id = $yorum["yorum_id"];
								$yorum_yapan = $yorum["uye_id"];
								$yazar = $db->query("SELECT * FROM uyeler WHERE uye_id = {$yorum_yapan}")->fetch(PDO::FETCH_ASSOC);
								echo '<p style="font-weight:bold">'.$yazar["isim"].'</p>';
								echo $yorum["yorum"];
								$alt_yorumlar = $db->query("SELECT * FROM yorumlar WHERE ust_id = {$ust_id}", PDO::FETCH_ASSOC);
								if($alt_yorumlar->rowCount()){
									foreach ($alt_yorumlar as $alt_yorum) {
										$alt_yorum_yapan = $alt_yorum["uye_id"];
										$alt_yazar = $db->query("SELECT * FROM uyeler WHERE uye_id = {$alt_yorum_yapan}")->fetch(PDO::FETCH_ASSOC);
										echo '<div class="yoruma_yorum" style="margin-left: 30px">
												<p style="font-weight:bold">'.$alt_yazar["isim"].'</p>
												<p>'.$alt_yorum["yorum"].'</p>
											</div>';
									}
								}
								 if (isset($_SESSION["giris"])){
								echo '<form style="margin-left:28px;" method="post" action="tarif_detay.php?id='.$_GET["id"].'">
										<input type="hidden" name="ust" value="'.$ust_id.'">
										<textarea  name="yorum" cols="65" rows="3"></textarea>
										<br>		
										<input type="submit" id="yorum_ekle" value="Cevap Ver">
									</form>';
								}

								
							}
						}

					?>
				</div>
				</div>
			</div>
		</div>
		
		<div class="categories">
			<p>Kategoriler</p>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
			<div class="category-menu"><a href="">Menü İsmi</a></div>
		</div>
	</section>

	<section class="content bg">
		<div class="recipies">
			
			
			
		</div>
		
		
	</section>
	
	<section class="content bg">
		<div class="recipies">
			<div class="recipe-title">
				<p>Menüler</p>
				<button class="all-see">Menü Gönder</button>
			</div>
			
			<div class="new-recipies">
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
				<div class="new-recipe">
					<img src="img/tarif.jpg" alt="" height="80" width="120">
					<div class="recipe-description">
						<p>Tarif ismi</p>
						<p>Kullanıcı Adı</p>
					</div>
				</div>
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