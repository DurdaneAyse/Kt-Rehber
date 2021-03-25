<?php
$questupdate = '';
$questerr1 = '';
$questerr2 = '';
$questerr3 = '';
$sifrehata = '';
$passup = '';
$facultyerr1 = 'none';
$facultyerr2 = 'none';
$facultyupdate = 'none';
require_once ("AllConnections.php");
$allFaculty = $tableFac->getAllFaculty();
echo'<!--Modified by F-SS-->';
session_start();
if (!isset($_SESSION["kadi"])){
    header('Location:index.php');
}
$sifre = 'none';
$yenisifre = 'none';

if(!isset($_GET['durum'])){
    $sifre = 'block';
    $yenisifre = 'none';
}
else if($_GET['durum'] == 'changepass'){
    $sifre = 'none';
    $yenisifre = 'block';
}
else if($_GET['durum'] == 'savepass'){//girilen yeni şifreler uyumluysa veri tabanına kayıt edildikten sonra bu kısmın çalışarak eski görünüme gelmesi gerek.
    $sifre = 'block';
    $yenisifre = 'none';
}
echo'<!--Created by HMN-->';
if (isset($_POST["question"])){
    if($_POST["baslik"] == ""){
        // baslik bos birakilmis hata yazdir
        $questerr1 = 'Başlık Kısmı Boş Bırakılamaz';
    }
    if($_POST["text"] == ""){
        // text bos birakilmis hata yazdir
        $questerr2 = 'Metin Kısmı Boş Bırakılamaz';
    }
    if($_POST["text"] != "" && $_POST["baslik"] != ""){
        $baslik = $_POST["baslik"];
        $yasaskArray = ["aptal","salak","mal"];
        $flag = true;
        foreach ($yasaskArray as $yasakKelime){
            if(strpos($yasakKelime, $baslik) !== false){
                $flag = false;
                break;
            } else{
                $flag = true;
            }
        }
        foreach ($yasaskArray as $yasakKelime){
            if(strpos($yasakKelime, $_POST["text"]) !== false){
                $flag = false;
                break;
            } else{
                $flag = true;
            }
        }
        if ($flag){
            try{
                if ($_POST["fakulte"] == "default"){
                    // defaultta bırakmıs //hata yadir
                    $questerr3 = 'Fakülte Seçmediniz';
                }
                else{
                    $fakulteId = (int)$_POST["fakulte"];
                    $message = $_POST["text"];
                    if ($tableQuestions->addQuestion($baslik,$_SESSION["kadi"],$fakulteId,$_SESSION["usrType"],$message)){
                        // soru eklendi bilgilendirme mesajı //hata yazdır
                        $questupdate = 'Sorunuz Eklenmiştir';
                    }
                    else{
                        // soru eklenemedi //hata yazdır
                        $questerr3 = 'Fakülte Eklenemedi';
                    }
                }
            }catch (Exception $e){
                //html ile faculty id si ile oynanamış //hata yazdir
                $questerr3 = 'Fakülte Seçimi Başarısız';
            }
        }
        else{
            //yasaklı kelime bulundu soru eklenemyecek //hata yazdır
            $questerr3 = 'Lütfen Terbiyenizden Ödün Vermeyiniz';
        }
    }
}
if(isset($_POST["savepass"])){
    $user = null;
    $sifeUser = null;
    if($_SESSION["usrType"] == 0){
        $user = $tableAnon->getAnon($_SESSION["kadi"]);
        $sifeUser = $user["Apassword"];
    }else{
        $user = $tableStudent->getStudent($_SESSION["kadi"]);
        $sifeUser = $user["Spassword"];
    }
    if ($_POST["eskisifre"] == ""){
        // eski şifre boş //hata yazdir
        $sifrehata = 'Eski Şifre Boş';
        $sifre = 'none';
        $yenisifre = 'block';
    }else{
        $sifre = md5($_POST["eskisifre"]);
        if ($sifeUser == $sifre) {
            if ($_POST["yenisifre2"] == ""){
                //yeni sifre2 bos birakilmis hata yazdir
                $sifrehata = 'Yeni Şifre Boş';
                $sifre = 'none';
                $yenisifre = 'block';
            }
            if ($_POST["yenisifre"] == ""){
                //yeni sifre bos birakilmis hata yazdir
                $sifrehata = 'Yeni Şifre Boş';
                $sifre = 'none';
                $yenisifre = 'block';
            }
            if ($_POST["yenisifre"] != "" && $_POST["yenisifre2"] != ""){
                if ($_POST["yenisifre"] == $_POST["yenisifre2"]){
                    if($_SESSION["usrType"] == 0){
                        if ($tableAnon->updateAnon($_SESSION["kadi"],$user["Aemail"],$_POST["yenisifre"])){
                            $passup = 'Güncelleme Başarılı';
                            
                        }else{
                            // güncellenmedi hata yazdir
                            $sifrehata = 'Şifre Değiştirme Başarısız';
                            $sifre = 'none';
                            $yenisifre = 'block';
                        }
                    }else{
                        $sifreCr = md5($_POST["yenisifre"]);
                        if ($tableStudent->updateStudent($_SESSION["kadi"],$user["Semail"],$sifreCr,$user["facultyId"])){
                            // sifre güncelelndi
                            $passup = 'Güncelleme Başarılı';
                        }else{
                            // güncellenmedi hata yazdir
                            $sifrehata = 'Şifre Değiştirme Başarısız';
                            $sifre = 'none';
                            $yenisifre = 'block';
                        }
                    }
                }else{
                    //sifreler esit degil hata yazdir
                    $sifrehata = 'Girilen Şifreler Uyuşmuyor';
                    $sifre = 'none';
                    $yenisifre = 'block';
                }
            }
        }else{
            //eski sifre uyusmuyor //hata yazdir
            $sifrehata = 'Eski Şifre Hatalı';
            $sifre = 'none';
            $yenisifre = 'block';
        }
    }
}
if(isset($_POST["kaydet"])){
    if ($_POST["fakulte"] != "default"){
        try {
            $newFakulteId = (int)$_POST["fakulte"];
            $student = $tableStudent->getStudent($_SESSION["kadi"]);
            if($tableStudent->updateStudent($student["id"],$student["Semail"],$student["Spassword"],$newFakulteId)){
                // ekleme tamam
                $facultyerr1 = 'none';
                $facultyerr2 = 'none';
                $facultyupdate = 'block';
            }else{
                // ekleme hatasi hata yazdir
                $facultyerr1 = 'none';
                $facultyerr2 = 'block';
                $facultyupdate = 'none';
            }
        }catch (Exception $e){
            // hmtl kısmınla oynanmış //hata yazdir
            $facultyerr1 = 'none';
            $facultyerr2 = 'block';
            $facultyupdate = 'none';
        }
    }else{
        //deafult seçmiş hata yazdir
        $facultyerr1 = 'block';
        $facultyerr2 = 'none';
        $facultyupdate = 'none';
    }
}
$userTopFacultyId = 0;
if ($_SESSION['usrType'] == 1){
    $userTopInfos = $tableStudent->getStudent($_SESSION["kadi"]);
    $userTopFacultyId = $userTopInfos["facultyId"];
}
    echo'
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
                        <a style="padding-left: 200px;padding-top: 25px;font-size: 50px;position: absolute;color: white;"href="index.php">MİNERVA</a>
                        <div class="user-bar">
                            <a type="button" class="user-button" href="profil.php">Profil</a>
                            <a> | </a>
                            <a type="button" class="user-button" href="index.php?cikis=cikis">Çıkış</a>
                        </div>
                    </div>
                    <div style="width: 100%; height: 75px; background-color: #302D2D;border-radius: 0px 0px 8px 8px;">
                        <div class="menu-bar">
                            <ul class="menu">
                                <li><a href="index.php?durum=hakkimizda">Hakkımızda</a></li>
                                <li><a href="index.php?durum=yardim">Yardım</a></li>
                                <li><a href="index.php?durum=ktu">Ktü</a></li>
                                <li><a href="sorular.php">Sorular</a></li>
                                <li><a href="index.php?durum=minerva">Ana Sayfa</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </header>
                <div class="clear"></div>
                <div class="cont" style="border-radius: 8px 8px 8px 8px;">
                    
                        <div class="cont" style="margin: 0px;background: #484444;height: 650px;">

                            <span style="margin-top:-29px;margin-left: 50px;position: absolute;display: ';if($questupdate == ''){echo'none';}else{echo'block';}echo';"><p class="zorunlu" style="color: #2A70B5;">'.$questupdate.'</p></span>
                            <span style="margin-top:-29px;margin-left: 50px;position: absolute;display: ';if($questerr1 == ''){echo'none';}else{echo'block';}echo';"><p class="zorunlu">'.$questerr1.'</p></span>
                            <span style="margin-top:-29px;margin-left:';if($questerr1 == ''){echo'50px';}else{echo'300px';}echo';position: absolute;display: ';if($questerr2 == ''){echo'none';}else{echo'block';}echo';"><p class="zorunlu">'.$questerr2.'</p></span>
                            <span style="margin-top:-29px;margin-left: 50px;position: absolute;display: ';if($questerr3 == ''){echo'none';}else{echo'block';}echo';"><p class="zorunlu">'.$questerr3.'</p></span>

                            <div>
                                <form method="post" action="profil.php" style="border: 1px solid black;border-radius: 4px;padding: 15px;background: #343434;"><!--php ile gönderilen başlık kontrol edilip veri tabanına eklenecek-->
                                    <span>Başlık</span>
                                    <input type="text" name="baslik" style="margin-left: 25px;width: 500px;" maxlength="50" class="textt">
                                    <select id="fakulte" name="fakulte" style="margin-left: 25px;line-height: 20px;border-radius: 8px;width: 265px;padding: 5px;height: 32px;">
                                        <option value="default">Fakülte Seçiniz</option><!--fakulteler çekilecek-->
                                        ';
                                            foreach ($allFaculty as $faculty){
                                            $facultId = $faculty["id"];
                                            $facultyName = $faculty["fName"];
                                            echo'<option value="'.$facultId.'">'.$facultyName.'</option>';
                                        }echo'
                                      </select>
                                    <textarea name="text" id="text" style="width: 850px;margin-left: 25px;margin-top: 25px;padding: 5px;" placeholder="Sorunuz Nedir? Lütfen Buraya Yazınız..."></textarea>
                                    <input type="submit" value="Oluştur" name="question" class="user-button" style="position: absolute;height: 170px;width: 125px; margin-top: 20px;" >
                                </form>
                                
                            </div>
                                ';
                                        $userEmail = null;
                                        if ($_SESSION["usrType"] == 1){
                                            $userInfo = $tableStudent->getStudent($_SESSION["kadi"]);
                                            $userEmail =  $userInfo["Semail"];
                                        }
                                        else{
                                            $userInfo = $tableAnon->getAnon($_SESSION["kadi"]);
                                            $userEmail = $userInfo["Aemail"];
                                        }
                                echo'
                            <!--Hata --------------------------------------------------------------------------------------------->
                            <span style="margin-left: 35px;position: absolute;"><p class="zorunlu" style="color: #2A70B5;">'.$passup.'</p></span>
                            <!---------------------------------------------------------------------------------------------------->
                            <div style="margin-top:35px;">
                                <div style="border: 1px solid black;border-radius: 4px;padding: 15px;position: absolute;background: #343434;width: 310px;">
                                    <span>E-Posta : </span>
                                    <span>'.$userEmail.'</span>
                                </div>
                                <div style="display:'.$sifre.';border: 1px solid black;border-radius: 4px;padding: 15px;position: absolute;background: #343434;margin-top: 70px;">
                                    <span>Şifre : </span>
                                    <span>***********</span>
                                </div>
                                <div style="display: '.$sifre.'; position: absolute;margin-left: 260px;margin-top:77px">
                                    <a href="profil.php?durum=changepass" class="user-button">Değiştir</a>
                                </div>
                                <!--Hata --------------------------------------------------------------------------------------------->
                                <span style="display: block;margin-top: 55px;margin-left: 15px;position: absolute;"><p class="zorunlu">'.$sifrehata.'</p></span>
                                <!---------------------------------------------------------------------------------------------------->
                                <form method="post" action="profil.php?durum=savepass" style="display: '.$yenisifre.';"><!--Şifre değiştirme kısmı eski şifrenin dp den kontrol edilmesi lazım-->
                                    <div style="border: 1px solid black;border-radius: 4px;padding: 15px;position: absolute;background: #343434;margin-top: 90px;">
                                        <span>Eski Şifre : </span>
                                        <input type="password" name="eskisifre" class="textt" style="width: 150px;">
                                    </div>
                                    <div style="border: 1px solid black;border-radius: 4px;padding: 15px;position: absolute;background: #343434;margin-top: 160px;">
                                        <span>Yeni Şifre : </span>
                                        <input type="password" name="yenisifre" class="textt" style="width: 150px;">
                                    </div>
                                    <div style="border: 1px solid black;border-radius: 4px;padding: 15px;position: absolute;background: #343434;margin-top: 230px;">
                                        <span>Yeni Şifre : </span>
                                        <input type="password" name="yenisifre2" class="textt" style="width: 150px;">
                                    </div>
                                    <div style="position: absolute;margin-left: 300px;margin-top:140px;">
                                        <button type="submit" class="user-button" name="savepass" style="height: 50px;">Kaydet</button><br>
                                        <a href="profil.php" class="user-button" style="margin-top: 15px;padding-left: 22px;padding-right: 22px;">Geri</a>
                                    </div>
                                </form>
                                <!--Buradan aşağısı eğer öğrenci ise gösterilecek-->
                                <span style="display:'.$facultyupdate.'; margin-left: 550px;position: absolute;margin-top: -25px;"><p class="zorunlu" style="color: #2A70B5;">Fakülte Değiştirildi</p></span>
                                <span style="display:'.$facultyerr2.'; margin-left: 550px;position: absolute;margin-top: -25px;"><p class="zorunlu">Fakülte Değiştirilemedi</p></span>
                                <span style="display:'.$facultyerr1.'; margin-left: 550px;position: absolute;margin-top: -25px;"><p class="zorunlu">Fakülte Seçmediniz</p></span>

                                <form method="POST" action="profil.php" style="display: '; if ($_SESSION["usrType"] == 1){echo 'block';}else{ echo "none";} echo'">
                                    <div style="border: 1px solid black;border-radius: 4px;padding: 15px;position: absolute;background: #343434;margin-top: 5px;margin-left: 500px;">
                                        <span>Falülte : </span>
                                        <select id="fakulte" name="fakulte" style="margin-left: 25px;line-height: 20px;border-radius: 8px;width: 300px;padding: 5px;height: 32px;">
                                        <option value="default">Fakülte Seçiniz</option><!--fakulteler çekilecek-->
                                        ';foreach ($allFaculty as $faculty){
                                            $facultId = $faculty["id"];
                                            $facultyName = $faculty["fName"];
                                            if ($facultId == $userTopFacultyId){
                                                echo'<option value="'.$facultId.'" selected>'.$facultyName.'</option>';
                                            }else{
                                                echo'<option value="'.$facultId.'">'.$facultyName.'</option>';
                                            }
}                                       echo'
                                      </select>
                                    </div>
                                    <div style="position: absolute;margin-left: 950px;margin-top:17px">
                                        <button type="submit" name="kaydet" class="user-button">Değiştir</button>
                                    </div>
                                </form>
                                <!-------------------------------------------------------------------------------------------------->
                            </div>
                        </div>

                    <div class="clear"></div>
                </div>
            </div>
        </body>
    </html>
';?>