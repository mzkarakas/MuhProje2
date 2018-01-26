<?php
require("inc/fonk.php"); //veri tabanı bağlantısı gerçekleştiriliyor


//formda kaydet butonuna basılıp basılmadığını kontrol ediyoruz.
if (isset($_POST['kaydet'])) {

    $id = $_GET["id"];

    //araba veri tabanından kullanıcı bilgilerini siliniyor
    $baglanti->query("DELETE FROM araba WHERE  kullaniciID=$id");

    //arabalar veri tabanından kullanıcıya ait araba bilgilerini siliniyor
    // bu kısımda  arabalar veri tabanında ki kullanıcı bilgisi eşleşme olmayaları siliniyor
    $baglanti->query("DELETE d FROM  arabalar d WHERE NOT EXISTS (SELECT * FROM araba WHERE arabalarID = d.id)");


    //kullanıcı adi ve soyadı bilgisi veritabanına ekle işlemi
    $sonuc = $baglanti->query(sprintf("UPDATE kullanici SET adi='%s', soyadi='%s' WHERE  id=$id", ($_POST['ad']), ($_POST['soyad'])));


    //Arabalar için gerekli alanlar eklenmişse kontrol ediliyor
    if ($_POST['alanlar']) {


        //alanlar metin kutusu kadar döngü yapılıyor
        foreach ($_POST['alanlar'] as $key => $value) {


            //Araba bilgilerine döngüde sırayala bakılıyor
            $baglanti->query(sprintf("INSERT INTO arabalar (arabalar_adi) VALUES ('%s')", ($value)));
            $eklenen_arabalar_id = $baglanti->insert_id;


            //araba tablosunda kullanıcı arabalar ilişkileri kaydediliyor 

            $baglanti->query(sprintf("INSERT INTO araba (kullaniciID, arabalarID) VALUES ('%s','%s')",
                ($id), ($eklenen_arabalar_id)));

        }

    }

    $baglanti->close(); //bağlantı sonlandırılma
    header("location:index.php"); // index.php sayfaya geri dönme
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Araba Düzenle</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
<body>
<form name="kullanici" method="post" action=""> <!--Form oluşturma -->
    <div class="container">
        <div class="col-md-12">
            <div class="col-md-6">
                <h1>Kullanıcı Araba Düzenle</h1>
            </div>
            <div class="col-md-4 text-center">

                <input id="kaydet" name="kaydet" type="submit" value="Kaydet" class="btn btn-success"/>
                <a href="index.php" id="iptal" class="btn btn-danger">İptal</a>
                <!-- kaydetme ve iptal düğmeleri ekleniyor -->
            </div>
        </div>
        <div class="col-md-12">
            <!-- Tab la menü bölümünde, içeriklerin bulunduğu div ler ile id lerin aynı olması  gerekiyor-->
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#kisiselBilgitab" aria-controls="kisiselBilgitab" data-toggle="tab">Kullanıcı Bilgileri</a>
                </li>
                <li role="presentation">
                    <a href="#arabalartab" aria-controls="arabalartab" role="tab" data-toggle="tab">Araba Bilgileri</a>
                </li>
            </ul>
            <!-- Tab panel -->
            <div class="tab-content">
                <!-- Ad soyad bilgisini aldığımız tab kısmı-->
                <div role="tabpanel" class="tab-pane active" id="kisiselBilgitab">
                    <br/>
                    <?php
                    if (isset($_GET["id"])) {
                        $id = $_GET["id"];

                        $sorgu = $baglanti->query("select * from kullanici where id=$id");
                        $sonuc = $sorgu->fetch_assoc();
                    } else
                        header("location:index.php");
                    ?>

                    <div class="col-md-6">
                        <table class="table-condensed">
                            <tr>
                                <td>Adınız:</td>
                                <td><input type="text" name="ad" id="ad" value="<?php echo $sonuc['adi'] ?>"
                                           class="form-control"/></td>
                            </tr>
                            <tr>
                                <td>Soyadınız:</td>
                                <td><input type="text" name="soyad" id="soyad" value="<?php echo $sonuc['soyadi'] ?>"
                                           class="form-control"/></td>
                            </tr>

                        </table>
                    </div>
                </div>
                <!-- Araba bilgilerini aldığımız tab kısmı-->
                <div role="tabpanel" class="tab-pane" id="arabalartab">
                    <br/>
                    <div class="col-md-6">
                        <table id="arabalar" class="table table-condensed">
                            <thead>
                            <tr>
                                <th><strong>Araba Sayısı</strong></th>
                                <th>Araba Adı</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sorgu = $baglanti->query("select d.arabalar_adi from arabalar d inner join araba od on od.arabalarID=d.id inner join kullanic o on o.id=od.kullaniciID where o.id=$id");
                            $sayac = 0;
                            while ($sonuc = $sorgu->fetch_assoc()) {
                                $sayac++;
                                ?>
                                <tr>
                                    <!-- tablonun body kısmında default 1. arabayi ekliyoruz
                                metin kutuları ise dizi olarak ekleniyor (alanlar[]).-->
                                    <th><strong>arabalar <?php echo $sayac ?> </strong></th>
                                    <td><input id="alan_<?php echo $sayac ?>" name="alanlar[]" type="text"
                                               value="<?php echo $sonuc['arabalar_adi'] ?>" class="form-control"></td>
                                    <?php
                                    if ($sayac != 1)
                                        echo '<td><a href="#" class="sil btn btn-danger">Sil</a></td>';
                                    else
                                        echo '<td></td>';
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <!-- footer alt kısımada araba ekle düğmesi ekleniyor-->
                            <tfoot>
                            <th></th>
                            <td></td>
                            <td>
                                <p id="ekle">
                                    <a href="#" class="btn btn-primary">&raquo; Yeni Araba Ekle </a>
                                </p>
                            </td>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">

    <?php echo "var sayac = " . $sayac; ?>

    $(function () {

        //ekle düğmesine tıklandığımızda çalışacak olan jquery fonksiyonunun kodlarını
        //bu kısımda table ın tbody kısmına (tr) yani satır ekleme yöntemiyle  araba içine input ediyoruz
        $('#ekle').click(function () {
            sayac += 1; //kaçıncı ders bilgisini tutuyoruz
            $('#arabalar tbody').append( //ekle
                '<tr><th><strong>arabalar ' + sayac + '</strong></th><td><input id="alan_' + sayac + '" name="alanlar[]' + '" type="text" class="form-control" /></td><td><a href="#" class="sil btn btn-danger">Sil</a></td></tr>');

        });

        //sil düğmesine tıklandığında çalışacak jquery fonksiyonu kodu
        //sil düğmesine tıklandığında tablodaki bulunduğu tr yi yani satırı siliyor.

        $('#arabalar').on("click", ".sil", function (e) {
            e.preventDefault();
            $(this).closest("tr").remove();

        })
    });

    //panellerin geçiş  sağlıyor.
    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>

</body>
</html>
