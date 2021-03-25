<?php
require_once ("AllConnections.php");
$displayk = 'none';
$displaye = 'none';
$displayp = 'none';
$displayp1 = 'none';
$displayg = 'none';
$displaygp = 'none';
$displayhata = 'none';
$displaygecersiz = 'none';
$kayitvar = 'none';
$displaygiris = 'none';
$displaykayit = 'block';
$kayithata = 'none';
$kayitogr = 'none';
$displayaktif = 'none';
$kayitdogru = 'none';
//SQL Bağlantısı
session_start();
echo'<!--Modified by F-SS-->';
if(isset($_SESSION['kadi']) || isset($_COOKIE['cookie']))
{
    header('Location:index.php');
}
//-----------------------------------------------------------------------
if(!isset($_GET))
{
    $displaygiris = 'none';
    $displaykayit = 'block';
}
else if(!isset($_GET['durum']))
{
    $displaygiris = 'none';
    $displaykayit = 'block';
}

else if($_GET['durum'] == 'kayit')//Kayıt butonuna basılıp bilgiler geldi ise
{
    $displaygiris = 'none';
    $displaykayit = 'block';
    if(isset($_POST['kayit']))
    {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        $student = null;
        $say = null;
        //Database de varmı kontrol
        if (isset($_POST["isStudent"])){
            $student = "anon";
            $say = $tableAnon->controlAnon($email);
        }
        else{
            $say = $tableStudent->controlStudent($email);
        }

        if($say > 0)
        {
            $kayitvar = 'block';
        }
        //---------------------------------------------------------
        else
        {
            if($_POST['email'] == '' || $_POST['pass'] == '' || $_POST['pass1'] == '')
            {
                if($email == '')
                {
                    $displaye = 'block';
                }
                if($pass == '')
                {
                    $displayp = 'block';
                }
                if($pass1 == '')
                {
                    $displayp1 = 'block';
                }
                if($pass != $pass1)
                {
                    $displayhata = 'block';
                }
            }
            else
            {
                if($pass != $pass1)
                {
                    $displayhata = 'block';
                }
                else
                {

                    if ($student == "anon"){
                        if($tableAnon->addNewAnon($email,$pass)){
                            // kayıt tamam
                            //header('Location:index.php');
                            $kayitdogru = 'block';
                            header("Refresh: 3; url=http://localhost/minerva/index.php");
                            //eposta gitti mesajı
                        }else{
                            // kayıt olmadı //hata yazdır
                            $kayithata = 'block';
                        }
                    }else{
                        $kayitSurec = $tableStudent->addNewStudent($email,$pass);
                        if($kayitSurec == "kayitOk"){
                            $kayitdogru = 'block';
                            header("Refresh: 3; url=http://localhost/minerva/index.php");
                            //Eposta gitti mesajı
                        }
                        else if($kayitSurec == "ögrenci emaili degil"){
                            // ögr epostası degil hata yazdır
                            $kayitogr = 'block';
                        }
                        else{
                            $kayithata = 'block';
                        }
                    }


                    //--------------------------------------------------------------------
                }
            }

        } 
    }
}
else if($_GET['durum'] == 'giris')//get ile giriş sayfasına yönlendirildi
{
    $displaygiris = 'block';
    $displaykayit = 'none';
    if(isset($_POST['giris']))//post ile geldiyse kontrol
    { 
        $gadi = $_POST['gadi'];
        $pass = $_POST['pass'];
        if($gadi == '' || $pass == '')
        {
            if($gadi == '')
            {
                $displayg = 'block';
            }
            if($pass == '')
            {
                $displaygp = 'block';
            }
        }
        else
        {
            //post edilen bilgilerde sıkıntı yoksa database de ara varsa cookie session oluştur.
            $student = $tableStudent->loginStudent($gadi,$pass);
            $anon = $tableAnon->loginAnon($gadi,$pass);
            $flag = true;
            if($anon == "Hesap Aktif Değil"){
                // hesap var ama aktif degil //hata yazdır
                $displayaktif = 'block';
            }elseif ($anon == false && $anon != "Hesap Aktif Değil"){
                if($student == "Hesap Aktif Değil"){
                    // hesap var ama aktif degil
                    $displayaktif = 'block';
                    $flag = false;
                }elseif ($student == false){
                    // hesap yok
                    $displaygecersiz = 'block';
                }else{
                    $studentInfo = $tableStudent->getStudenEmail($gadi);
                    $_SESSION['kadi'] = $studentInfo["id"];
                    $_SESSION['usrType'] = 1;
                    $kadipass = array('kadi'=>$gadi,'pass'=>$pass);
                    if(isset($_POST['hatirla']))
                    {
                        $hatirla = $_POST['hatirla'];
                        if($hatirla == 1)
                        {
                            setcookie('cookie',serialize($kadipass),time()+8400);
                        }
                    }
                    header('Location:index.php');
                }
                if ($flag != false)
                $displaygecersiz = 'block';
            }else{
                $anoninfo = $tableAnon->getAnonEmail($gadi);
                $_SESSION['kadi'] = $anoninfo["id"];
                $_SESSION['usrType'] = 0;
                $kadipass = array('kadi'=>$gadi,'pass'=>$pass);
                if(isset($_POST['hatirla']))
                {
                    $hatirla = $_POST['hatirla'];
                    if($hatirla == 1)
                    {
                        setcookie('cookie',serialize($kadipass),time()+8400);
                    }
                }
                header('Location:index.php');

            }

        }
    }
}
echo'<!--Created by HMN-->';
echo '
<!DOCTYPE html>
<html lang="tr-TR" style="position: relative;background-color: grey;">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="kayit.css">
</head>
<body>
    <div class="page">
        <header>
            <div style="width: 100%; height: 100px; background-color: #484444;border-radius: 8px 8px 0px 0px;">
                <a href="index.php"><img src="image/ktulogo.png" style="width: 150px;height: 150px;position: absolute;padding-top: 10px;padding-left: 25px;"></a>
                <a style="padding-left: 200px;padding-top: 25px;font-size: 50px;position: absolute;color: white;"href="index.php">MİNERVA</a>
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
        <div class="cont" style="border-radius: 8px;">
            <div style="padding:15px">   
                <div style="display:'.$displaykayit.'">
                    <div style="padding: 15px;" >
                        <br>
                        <h1 class="kaydol">Kaydolun</h1>
                        <p style="line-height: 20px;color: #8d9aa6;font-size: 16px;text-align: center;">Kayıtlı kullanıcı mısınız? 
                            <a href="kayit.php?durum=giris" style="color: #3d6594;">Giriş Yap</a><!-- Giriş sayfasına yönlendirmesi için get ile giris gonder  -->
                        </p>
                    </div>
                    <div class="kayit-cerceve">
                        <form method="post" action="kayit.php?durum=kayit" style="padding: 30px;background-color: #484444;border-radius: 8px;">
                            <div style="padding: 15px 15px 0px 15px;">
                                <ul style="list-style: none;">
                                    <span style="display: '.$kayitdogru.';"><p class="zorunlu" style="font-weight:700;color: #2A70B5;;">Lütfen E-Postanızı Kontrol Edin</p></span>
                                    <span style="display: '.$kayitvar.';"><p class="zorunlu">E-posta alınmıştır.</p></span>
                                    <span style="display: '.$kayithata.';"><p class="zorunlu">Kayıt Başarısız Oldu!</p></span>
                                    <span style="display: '.$kayitogr.';"><p class="zorunlu">Lütfen Öğrenci E-Postanızı Giriniz.</p></span>
                                    <li style="margin-bottom: 15px;">

                                        <input type="checkbox" name="isStudent" ><label class="kayit-label" style="font-weight: 800;">Öğrenci Değilim</label><br>
                                        
                                    </li>
                                    <li style="margin-bottom: 15px;">
                                        <label class="kayit-label"  >E-Posta Adresi
                                            <span class="gerekli"> Gerekli</span>
                                        </label>
                                        <div>
                                            <input type="email" name="email" value="" maxlength="30" class="input">
                                            <span style="display: '.$displaye.';"><p class="zorunlu">Bu alan zorunludur.</p></span>
                                        </div>
                                    </li>
                                    <li style="margin-bottom: 15px;">
                                        <label class="kayit-label"  >Şifre
                                            <span class="gerekli"> Gerekli</span>
                                        </label>
                                        <div>
                                            <input type="password" name="pass" value="" maxlength="15" class="input">
                                            <span style="display: '.$displayp.';"><p class="zorunlu">Bu alan zorunludur.</p></span>
                                            </div>
                                    </li>
                                    <li style="margin-bottom: 15px;">
                                        <label class="kayit-label"  >Şifre Tekrar
                                            <span class="gerekli"> Gerekli</span>
                                        </label>
                                        <div>
                                            <input type="password" name="pass1" value="" maxlength="15" class="input">
                                            <span style="display: '.$displayp1.';"><p class="zorunlu">Bu alan zorunludur.</p></span>
                                            <span style="display: '.$displayhata.';"><p class="zorunlu">Şifreleriniz eşleşmedi.</p></span>
                                        </div>
                                    </li>
                                    
                                    <div class="button-div">
                                        <button class="button" type="submit" name="kayit">Hesabımı Oluştur</button>
                                    </div>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
                <div style="display:'.$displaygiris.'">
                        <div style="padding: 15px;">
                            <br>
                            <h1 class="kaydol">Giriş Yap</h1>
                            <p style="line-height: 20px;color: #8d9aa6;font-size: 16px;text-align: center;">Hesabınız yok mu?
                                <a href="kayit.php?durum=kayit" style="color: #3d6594;">Kayıt Olun</a><!-- Kayıt sayfasına yönlendirmesi için get ile kayit gonder  -->
                                
                            </p>
                        </div>
                        <div class="kayit-cerceve">
                            <form method="post" action="kayit.php?durum=giris" style="padding: 30px;background-color: #484444;border-radius: 8px;">
                                <div style="padding: 15px 15px 0px 15px;">
                                    <ul style="list-style: none;">
                                        <li style="margin-bottom: 15px;">
                                            <span style="display: '.$displaygecersiz.';"><p class="zorunlu">Geçersiz E-Posta veya Şifre!</p></span>
                                            <span style="display: '.$displayaktif.';"><p class="zorunlu">E-Posta Aktif Edilmemiş!</p></span>
                                            <label class="kayit-label" >E-Posta
                                                <span class="gerekli"> Gerekli</span>
                                            </label>
                                            <div>
                                                <input type="text" name="gadi" placeholder="E-Posta" maxlength="30" class="input">
                                                <span style="display: '.$displayg.';"><p class="zorunlu">Bu alan zorunludur.</p></span>
                                            </div>
                                        </li>
                                        <li style="margin-bottom: 15px;">
                                            <label class="kayit-label"  >Şifre
                                                <span class="gerekli"> Gerekli</span>
                                            </label>
                                            <div>
                                                <input type="password" name="pass" placeholder="Şifre" maxlength="15" class="input">
                                                <span style="display: '.$displaygp.';"><p class="zorunlu">Bu alan zorunludur.</p></span>
                                            </div>
                                        </li>
                                        <li>
                                            <span>
                                                <input type="checkbox" name="hatirla" value="1" style="float: left;margin-top: 3px;width: 15px;height: 15px;">
                                            </span>
                                            <div style="margin-left: 24px;">
                                                    <label>Beni hatırla</label><br>
                                                    <span style="font-size: 12px;color: #8d9aa6;margin-top: 3px;display: inline-block;">Paylaşımlı bilgisayarlarda önerilmez</span>
                                            </div>
                                        </li>
                                        <div class="button-div">
                                            <button onclick="display(0)" class="button" type="submit" name="giris">Giriş Yap</button>
                                        </div>
                                    </ul>
                                </div>
                            </form>
                        </div>
                        
                    </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    </body>
    </html> ';
    

?>