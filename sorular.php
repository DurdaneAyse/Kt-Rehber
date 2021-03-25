<?php
require_once ("AllConnections.php");
echo'<!--Modified by F-SS-->';
session_start();
$allFaculty = $tableFac->getAllFaculty();
$actionfId = null;
$allQuestions = null;
echo'<!--Created by HMN-->';
if(isset($_GET["fakulte"])){
    $fId = $_GET["fakulte"];
    if($fId == "default"){
        header('Location:sorular.php');
    }
    if($fId != null && $fId != ""){
        if ($fId<=17){ // 17 fakülte var
            if(isset($_POST["aramaButton"])){
                $arama = $_POST["arama"];
                $allQuestions = $tableQuestions->getMessageIdFaculty($fId,$arama);
            }else{
                $allQuestions = $tableQuestions->getQuestionsFaculty($fId);
            }
            $actionfId = "?fakulte=".$fId;
        }else{
            //Maksimim ıd 17 eger değiştirilirse // hata yazdır
            header('Location:sorular.php');
        }
    }else{
        /// eger fid="" bırakılırsa yapılackalar // hata yazdır
        header('Location:sorular.php');
    }
}else{
    $allQuestions = $tableQuestions->getQuestionsAllFaculty();
    if(isset($_POST["aramaButton"])){
        $arama = $_POST["arama"];
        $allQuestions = $tableQuestions->getMessageFaculty($arama);
    }
    $actionfId = "";
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
                        <div class="user-bar" style="display:';if (isset($_SESSION["kadi"])){echo"block"; }else{echo"none";} echo'">
                            <a type="button"  class="user-button" href="profil.php">Profil</a><!--Giriş yapıldıysa sadece bu görünücek-->
                            <a> | </a>
                            <a type="button" class="user-button" href="index.php?cikis=cikis">Çıkış</a>
                        </div>
                        <div class="user-bar" style="display:';if (isset($_SESSION["kadi"])){echo"none"; }else{echo"block";} echo '" >
                            <a type="button"  href="kayit.php?durum=giris" class="user-button">Giriş</a>
                            <a>  |  </a>
                            <a type="button" class="user-button" href="kayit.php?durum=kayit">Kayıt Ol</a>
                        </div>
                        <div class="clear"></div>
                        <!-- GET ile aratılan veri tabanından çekilerek aşağıdaki soruların yazdırıldığı bölüme yazdırılacak dönen link ....php?arama=aranan şeklinde (Başka bir sayfadan da istek gelebilir)
                        Post ile daha iyi
                        -->
                        <form action="sorular.php'.$actionfId.'" method = "POST" class="user-bar">
                            <div style="width: 600px;">
                                <input type="text" name="arama" style="font-size: 13px;" class="search-bar" placeholder="Merak Ettiğiniz Nedir ?">
                            </div>
                            <button type="submit" class="search-button" name="aramaButton">
                                <img style="width: 30px; padding: 2px;" src="image/search-solid.svg">
                            </button>
                        </form>

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
                <div class="cont" style="border-radius:8px;margin-bottom: 0px; margin-top: 10px;">
                    
                    <!--Fakulte çekme (Getirilen fakülde görünmeli)-->
                    <form action="sorular.php" align="center" method="GET">
                        <span>Falülte : </span>
                        <select id="fakulte" name="fakulte" style="margin-left: 25px;line-height: 20px;border-radius: 8px;width: 500px;padding: 5px;height: 32px;">
                        <option value="default">Fakülte Seçiniz</option><!--fakulteler çekilecek-->
                        ';foreach ($allFaculty as $faculty){
                            $facultId = $faculty["id"];
                            $facultyName = $faculty["fName"];
                            echo'<option value="'.$facultId.'">'.$facultyName.'</option>';
}                                       echo'
                        </select>
                        <span><button type="submit" style="margin-left: 10px;" class="user-button">Getir</button></span>
                    </form>
                    <div class="clear"></div>
                <!------------------------------------------------------------------------------------------>

                </div>
                <div class="clear"></div>
                <div class="cont" style="border-radius: 8px; margin-top:10px;">
                    <!-- Burada otomatik alt alta divler ile sorular sıralanıcak aşağıdaki 2 soruluk ornek gibi
                    Tamam Abey-->
                    ';
                        if ($allQuestions != null){
                            foreach ($allQuestions as $question){
                                $questionId = $question["id"];
                                // user type abimiz anonmmi stduentmı diye 0 anon 1 student iki farklı tabloda bulnalr id cakısması olmasındiye
                                $userType = $question["userType"];
                                $userInfos = null;
                                $questionerEmail = null;
                                $facultyId = $question["faculty"];
                                $facultyInfo = $tableFac->getFacultyId($facultyId);
                                $facultyName = $facultyInfo["fName"];
                                if ($userType == 0){
                                    $userInfos = $tableAnon->getAnon($question["questionerid"]);
                                    $questionerEmail = $userInfos["Aemail"];
                                }else{
                                    $userInfos = $tableStudent->getStudent($question["questionerid"]);
                                    $questionerEmail = $userInfos["Semail"];
                                }
                                $questionTime = $question["time"];
                                $questionMsg = $question["question"];
                                echo '<div class="yorum">
                                    <label style="float: right;">Soru Time = '.$questionTime.'</label>
                                      <a href="cevaplar.php?id='.$questionId.'"><p class="yorum-p">'.$facultyName.'<br>Soru =  '.$questionMsg.'</p></a><!--fakülte db den sorularda rastgele en son eklenme tarihine göre sıralansın-->
                                  </div>';
                            }
                        }
                    echo'
                </div>
            </div>
        </body>
    </html>
';?>