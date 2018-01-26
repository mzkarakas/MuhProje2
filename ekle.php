<?php
require("inc/fonk.php"); //veri tabanı bağlantısı gerçekleştiriliyor
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Araba Ekle</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
<body>
<form name="kullanici" method="post" action=""> <!--Formu oluşturma -->
    <div class="container">
        <div class="col-md-12">
            <div class="col-md-6">
                <h1>Kullanıcı Araba Ekle</h1>
            </div>
            <div class="col-md-4 text-center">
                <input id="kaydet" name="kaydet" type="submit" value="Kaydet" class="btn btn-success"/>
                <a href="index.php" id="iptal" class="btn btn-danger">İptal</a>
                <!-- kaydet ve iptal düğmeleri ekleniyor -->
            </div>
        </div>
        <div class="col-md-12">

            <!-- Tab ların menü kısmı, burada içeriklerin olduğu div ler ile id lerin aynı olması lazım -->
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <li role="presentation" class="active"><a href="#kullaniciBilgitab" aria-controls="kullaniciBilgitab"
                                                          data-toggle="tab">Kullanıcı Bilgiler</a></li>
                <li role="presentation"><a href="#arabalartab" aria-controls="arabalartab" role="tab" data-toggle="tab">Araba
                        Bilgileri</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- kullanıcı bilgileri alınıyor div-->
                <div role="tabpanel" class="tab-pane active" id="kullaniciBilgitab">
                    <br/>
                    <div class="col-md-6">
                        <table class="table-condensed">
                            <tr>
                                <td>Adınız:</td>
                                <td><input type="text" name="ad" id="ad" class="form-control"/></td>
                            </tr>
                            <tr>
                                <td>Soyadınız:</td>
                                <td><input type="text" name="soyad" id="soyad" class="form-control"/></td>
                            </tr>
                        </table>
                    </div>

                </div>
                <!-- Araba bilgilerini aldığımız kısım div-->
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
                            <tr>
                                <!-- tablonun body kısmında varsayılan olarak 1. Dersi ekliyoruz
                            metin kutularını dizi olarak ekliyoruz (alanlar[]).-->
                                <th><strong>Araba 1</strong></th>
                                <td><input id="alan_1" name="alanlar[]" type="text" class="form-control">
                                
                                </select>
                                </td>
                                <td></td>
                            </tr>
                            </tbody>

                            <!-- footer kısmında araba ekle düğmesi ekliyoruz-->
                            <tfoot>
                            <th></th>
                            <td></td>
                            <td><p id="ekle"><a href="#" class="btn btn-primary">&raquo; Yeni araba Ekle </a></p></td>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php
//formda kaydet butonuna basılması kontrol ediliyor
if (isset($_POST['kaydet'])) {

    //Kullanici adi ve soyadı bilgileri veritabaına yazılıyor
    $sonuc = $baglanti->query(sprintf("INSERT INTO kullanici (adi, soyadi) VALUES ('%s','%s')", ($_POST['ad']), ($_POST['soyad'])));

    //arabalar  için gerekli alanlar doldurulmusa check ediliyor
    if ($_POST['alanlar']) {

        //en son eklenen id alıyoruz
        $eklenen_kullnici_adi = $baglanti->insert_id;

        //alanlar metin kutuları kadar döngü oluşturuyoruz.
        foreach ($_POST['alanlar'] as $key => $value) {

            //arabalar bilgilerini döngü içinde sırayla kaydediyoruz.
            $baglanti->query(sprintf("INSERT INTO arabalar (arabalar_adi) VALUES ('%s')", ($value)));
            $eklenen_araba_id = $baglanti->insert_id;

            //araba tablomuzda ogrenci araba ilişki bilgilerini tutuyoruz

            $baglanti->query(sprintf("INSERT INTO araba (kullaniciID, arabalarID) VALUES ('%s','%s')",
                ($eklenen_kullanici_adi), ($eklenen_arabalar_id)));
        }
    }

    $baglanti->close(); //bağlantımızı sonlandırıyoruz
    header("location:index.php"); // index.php sayfasına geri dönüyoruz.
}
?>

<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">

    //ekle bağlantısına tıklandığında çalışacak jquery kodlarımız
    //burada table ın tbody kısmına satır (tr) ekleme yöntemi ile ders için input ekliyoruz.
    var sayac = 1; //kaçıncı arabalar bilgisini tutuyoruz
    $(function () {
        $('#ekle').click(function () {
            sayac += 1;
            $('#arabalar tbody').append(
                '<tr><th><strong>arabalar ' + sayac + '</strong></th><td><input id="alan_' + sayac + '" name="alanlar[]' + '" type="text" class="form-control" /></td><td><a href="#" class="sil btn btn-danger">Sil</a></td></tr>');
        });


        //sil bağlantısına basıldığında çalışan jquery kodu
        //sil tıklandığında tablodaki bulunduğu tr satırı yi siliyoruz
        $('#arabalar').on("click", ".sil", function (e) { //user click on remove text
            e.preventDefault();
            $(this).closest("tr").remove();

        })
    });

    //panellerin geçişini sağlıyor.
    $('#myTabs a').click(function (e) {  
        e.preventDefault()
        $(this).tab('show')
    })
</script>
</body>
</html>
