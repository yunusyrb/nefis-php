<?php 

include "sistem/ayar.php";

if(isset($_GET)) {
    if(isset($_GET["begen"])) {
        $uye_id = $_SESSION["giris"];
        $tarif_id = $_GET["begen"];

		$ekle = $db->prepare("INSERT INTO begeniler (uye_id,tarif_id) VALUES (?,?)")->execute(array($uye_id,$tarif_id));
        if($ekle) {
            header("Location:tarif_detay.php?id=" . $tarif_id);
        }
    } else {
        $uye_id = $_SESSION["giris"];
        $tarif_id = $_GET["begenme"];

        $sorgu = $db->prepare("DELETE FROM begeniler WHERE uye_id = " . $uye_id . " AND tarif_id = " . $tarif_id);
        $sil = $sorgu->execute();
        if($sil) {
            header("Location:tarif_detay.php?id=" . $tarif_id);
        }
    }
} else {
    header("Location:index.php");    
}
