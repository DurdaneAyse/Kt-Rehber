<?php
require_once("AllConnections.php");
session_start();
if (isset($_GET["cikis"])) {  // cikis blogu hepsi indexe gelicek
    $cikis = $_GET["cikis"];
    if ($cikis == "cikis") {
        session_destroy();
        setcookie("cookie", '', time() - 1000);
        header('Location:index.php');
    }
}
$minerva = 'none';
$ktu = 'none';
$yardim = 'none';
$hakkimizda = 'none';
echo'<!--Modified by F-SS-->';
if (!isset($_GET['durum'])) {
    $minerva = 'block';
    $ktu = 'none';
    $yardim = 'none';
    $hakkimizda = 'none';
} else if ($_GET['durum'] == 'minerva') {
    $minerva = 'block';
    $ktu = 'none';
    $yardim = 'none';
    $hakkimizda = 'none';
} else if ($_GET['durum'] == 'ktu') {
    $minerva = 'none';
    $ktu = 'block';
    $yardim = 'none';
    $hakkimizda = 'none';
} else if ($_GET['durum'] == 'yardim') {
    $minerva = 'none';
    $ktu = 'none';
    $yardim = 'block';
    $hakkimizda = 'none';
} else if ($_GET['durum'] == 'hakkimizda') {
    $minerva = 'none';
    $ktu = 'none';
    $yardim = 'none';
    $hakkimizda = 'block';
}
$allFaculty = $tableFac->getAllFaculty();
$facultyName = null;
$facultyAddres = null;
echo'<!--Created by HMN-->';
if (isset($_GET["fid"])) {
    $lastQuestions = $tableQuestions->getQuestionsFacultyLastSix($_GET["fid"]);
    $id = (int)$_GET["fid"];
    if ($id == 0) {
        // str deger girmis istersen //hata yazdir
        $lastQuestions = $tableQuestions->getQuestionsFacultyLastSix(1);
        $facultyInfoUp = $tableFac->getFacultyId(1);
        $facultyName = $facultyInfoUp["fName"];
        $facultyAddres = $facultyInfoUp ["adress"];
    }
    elseif ($lastQuestions >= $id) {
        $facultyInfoUp = $tableFac->getFacultyId($_GET["fid"]);
        $facultyName = $facultyInfoUp["fName"];
        $facultyAddres = $facultyInfoUp ["adress"];
    } else {
        // str deger girmis istersen  hata yazdir
        $lastQuestions = $tableQuestions->getQuestionsFacultyLastSix(1);
        $facultyInfoUp = $tableFac->getFacultyId(1);
        $facultyName = $facultyInfoUp["fName"];
        $facultyAddres = $facultyInfoUp ["adress"];
    }

} else {
    $lastQuestions = $tableQuestions->getQuestionsFacultyLastSix(1);
    $facultyInfoUp = $tableFac->getFacultyId(1);
    $facultyName = $facultyInfoUp["fName"];
    $facultyAddres = $facultyInfoUp ["adress"];
}

echo '
    <!DOCTYPE html>
    <html lang="tr-TR" style="position: relative; background-color: grey;">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="genel.css">
        </head>
        <body>
            <div class="page">
                <header>
                    <div style="width: 100%; height: 100px; background-color: #484444;border-radius: 8px 8px 0px 0px;">
                        <a href="index.php"><img src="image/ktulogo.png" style="width: 150px;height: 150px;position: absolute;padding-top: 10px;padding-left: 25px;"></a>
                        <a style="padding-left: 200px;padding-top: 25px;font-size: 50px;position: absolute;color: white;"href="index.php">M??NERVA</a>
                        <div class="user-bar" style="display:';
if (isset($_SESSION['kadi'])) {
    echo 'block';
} else {
    echo 'none';
}
echo '">
                            <a type="button"  class="user-button" href="profil.php">Profil</a><!--Giri?? yap??ld??ysa sadece bu g??r??n??cek-->
                            <a> | </a>
                            <a type="button" class="user-button" href="index.php?cikis=cikis">????k????</a>
                        </div>
                        <div class="user-bar" style="display:';
if (isset($_SESSION['kadi'])) {
    echo 'none';
} else {
    echo 'block';
}
echo '" >
                            <a type="button"  href="kayit.php?durum=giris" class="user-button">Giri??</a>
                            <a>  |  </a>
                            <a type="button" class="user-button" href="kayit.php?durum=kayit">Kay??t Ol</a>
                        </div>
                        
                    </div>
                    <div style="width: 100%; height: 75px; background-color: #302D2D;border-radius: 0px 0px 8px 8px;">
                        <div class="menu-bar">
                            <ul class="menu">
                                <li><a href="index.php?durum=hakkimizda">Hakk??m??zda</a></li>
                                <li><a href="index.php?durum=yardim">Yard??m</a></li>
                                <li><a href="index.php?durum=ktu">Kt??</a></li>
                                <li><a href="sorular.php">Sorular</a></li>
                                <li><a href="index.php?durum=minerva">Ana Sayfa</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </header>
                <div class="clear"></div>
                <div class="cont" style="border-radius: 8px 8px 8px 8px;">

                    <div style="display:' . $minerva . ';">
                        <div class="leftside">
                            <div style="height: 150px;width: 100%;">
                                <!--Burda default olarak di?? hekimli??i gelsin Fak??lte ad?? ve adres-->
                                <p style="padding-top: 25px;padding-left: 25px;">' . $facultyName . '</p><p style="padding-top: 25px;padding-left: 25px;">Adres : ' . $facultyAddres . '</p>

                            </div>
                            <div style="height: 600px;width: 100%;">
                                ';

foreach ($lastQuestions as $question) {
    $questionTime = $question["time"];
    $questionTitle = $question["question"];
    $questionId = $question["id"];
    $questionFacultyId = $question["faculty"];
    $facultyInfo = $tableFac->getFacultyId($questionFacultyId);
    $facutyName = $facultyInfo["fName"];
    echo '<div style="width: 100%;height: 15px;background: #302D2D;"></div>
                                                                    <div class="yorum" style="max-height: 50px;">
                                                                        <label style="float: right;">Soru Time = ' . $questionTime . '</label>
                                                                        <a href="cevaplar.php?id=' . $questionId . '"><p class="yorum-p" >' . $facutyName . '<br>Soru = ' . $questionTitle . '</p></a><!--fak??lte db den sorularda rastgele en son eklenme tarihine g??re s??ralans??n-->
                                                                    </div>';
}


echo '
                                <!-------------------------------------------------------->
                            </div>
                        </div>
                        <div class="rightside">
                            <div style="width: 100%;height: 780px;">
                                <div class="cont" style="margin-bottom: 0px;background: #484444;padding-top: 0px;">
                                <p style="font-size: 25px;">FAK??LTELER??M??Z</p><br>
                            <ul style="line-height: 20px;">';
foreach ($allFaculty as $fac) {
    // SAG TARAF FAKULTELER??N BASILDIGI KISIM
    $facId = $fac['id'];
    $facName = $fac['fName'];
    echo '<li><a href="index.php?fid=' . $facId . '">' . $facName . '</a></li><br><!--G??nderilen id ile sorular sayfas?? a????ld??????nda a????lan fak??lte se??ili g??z??kmeli-->';
}
echo '
                            </ul>
                        </div>
                            </div>
                        </div>
                    </div>

                    <div style="display:' . $ktu . ';">
                        <div class="cont" style="margin: 0px;background: #484444;">
                            <p>Karadeniz Teknik ??niversitesi veya k??saca, Trabzon Milletvekili Mustafa Re??it Tarak????o??lu ve 28 arkada????n??n verdi??i teklifin, T??rkiye B??y??k Millet Meclisinde 20 May??s 1955 tarih ve 6594 say??l?? kanunla kabul edilmesi ile kurulmu??tur.</p>
                            <br><p>Adres: ??niversite, 61080 Ortahisar/Trabzon</p>
                        </div>
                        <div class="cont" style="margin-bottom: 0px;background: #484444;">
                            <p style="font-size: 20px;">FAK??LTELER??M??Z</p><br>
                            <ul style="line-height: 20px;">';
foreach ($allFaculty as $fac) {
    // SAG TARAF FAKULTELER??N BASILDIGI KISIM
    $facId = $fac['id'];
    $facName = $fac['fName'];
    echo '<li><a href="index.php?fid=' . $facId . '">' . $facName . '</a></li><br><!--G??nderilen id ile sorular sayfas?? a????ld??????nda a????lan fak??lte se??ili g??z??kmeli-->';
}
echo '
                            </ul>
                        </div>
                    </div>

                    <div style="display:' . $yardim . ';">
                        <div class="cont" style="margin: 0px;background: #484444;">
                            <p>S??TE KULLANIMI ??LE ??LG??L?? B??LG??</p>
                        </div>
                    </div>

                    <div style="display:' . $hakkimizda . ';">
                        <div class="cont" style="margin: 0px;background: #484444;">
                            <p>Minerva anlam?? eme??i ge??enler...</p>
                        </div>
                    </div>



                    <div class="clear"></div>
                </div>
            </div>
        </body>
    </html>
'; ?>