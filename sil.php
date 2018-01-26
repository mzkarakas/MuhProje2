<?php
if($_GET["id"]) {
    require("inc/fonk.php"); //fonk.php ile veritabanına bağıyoruz

    //Get ile gelen id integer türüne pars ile çevirip değişkende tutulması sağlanıyor
    $ogrid = (int)$_GET["id"];

    //araba veri tabanından kullanici bilgilerini siliyoruz
    $baglanti->query("DELETE FROM araba WHERE  kullaniciID=$ogrid");

    //arabalar veri tabanından kullanici ait arabalar bilgilerini siliyoruz
    // burada arabalar veri tabanında ogrenci bilgisi eşleşmeyenleri siliyoruz
    $baglanti->query("DELETE d FROM arabalar d WHERE NOT EXISTS (SELECT * FROM araba WHERE arabalarID = d.id)");

    //Son olarak kullanici tablosundan kullanıcı bilgisi silme işlemi
    $baglanti->query("DELETE FROM kullanici WHERE  id=$ogrid");

    //index sayfamıza geri dönüyoruz.
    header("location:index.php");
}
//Eğer get ile veri gelmemişse index sayfasına dönüyoruz
header("location:index.php");