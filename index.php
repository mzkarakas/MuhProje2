<?php
require("inc/fonk.php"); //veri tabanı bağlantısı gerçekleştiriliyor
?>
<!doctype html>
<html lang="tr">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Araba Listesi</title>
</head>
<body>
<br>
<div class="container">
    <div class="col-md-8">
        <table class="table table-bordered table-condensed">
            <thead>
            <tr>
                <th>Kullanıcı Adı</th>
                <th>Kullanıcı Soyadı</th>
                <th colspan="2" class="text-center">İşlemler</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //kullanıcı tablosundan tüm veriyi çekiyoruz
            //Çekilen veriyi tablo halinde yazdırıyoruz
            //düzenle ve sil linklerini ekliyoruz
            $sorgu = $baglanti->query("select * from kullanici");
            while ($sonuc = $sorgu->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $sonuc["adi"] ?></td>
                    <td><?php echo $sonuc["soyadi"] ?></td>
                    <td class="text-center">
                        <a class="islem" href='duzenle.php?id=<?php echo $sonuc["id"] ?>'>
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="islem" href='sil.php?id=<?php echo $sonuc["id"] ?>'>
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <a class="btn btn-primary" href="Ekle.php">Yeni Kayıt Ekle</a>
    </div>
</div>
</body>
</html>