<?php
$eklenemedi = 'none';
require_once ("AllConnections.php");
echo'<!--Modified by F-SS-->';
session_start();
if(isset($_GET["id"])){
    $questionId = $_GET["id"];
    $lastId = $tableQuestions->getLastId();
    $allAnswers = null;
    if ($questionId<=$lastId){
        // bütün sorular bu arrayde
        $allAnswers = $tableAnswers->getAllQuestionAnswer($questionId);
        $question = $tableQuestions->getQuestionId($questionId);
        $questionFacultyId = $question["faculty"];
        $facultyInfo = $tableFac->getFacultyId($questionFacultyId);
        $facultyName = $facultyInfo["fName"];
    }else{
        //Maksimim ıd lastid eger değiştirilirse // hata yazdır
        header('Location:sorular.php');
    }
}
else{
    //fid bizim get degerimiz içinde faculte idsi var eger orayla oynamışssa //hata yazdır
    header('Location:sorular.php');
}
echo'<!--Created by HMN-->';
if(isset($_POST["textarea-yorum-button"])){
    $answer = $_POST["textarea-yorum"];
    if ($_SESSION['usrType'] == 0){
        if($tableAnswers->addAnswer($answer,$_SESSION["kadi"],$questionId,0)){
            header('Location:cevaplar.php?id='.$questionId.'');
        }else{
            // soru eklenmedi //hata yazdır
            $eklenemedi = 'block';
        }
    }else{
        if($tableAnswers->addAnswer($answer,$_SESSION["kadi"],$questionId,1)){
            header('Location:cevaplar.php?id='.$questionId.'');
        }else{
            // soru eklenmedi //hata yazdır
            $eklenemedi = 'block';
        }
    }
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
                        <!-- GET ile aratılan sorular.php sayfasına gönderiliyor. 
                        Hayır ben onu post yaptım-->
                        <form action="sorular.php" method = "POST" class="user-bar">
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
                <div class="cont" style="border-radius: 8px 8px 8px 8px;">
                    <span style="display: '.$eklenemedi.';"><p class="zorunlu">Yorumunuz Eklenirken Bir Hata Oluştu</p></span>
                    <!--Örnek soru-->
                    <div class="yorum" style="margin-top: 0px;">
                        <label class="yorum-p">'.$facultyName.'</label><!--kullanıcının soru oluştururken seçtiği fakülte-->
                        <label class="yorum-p" style="float: right;">'.$question["time"].'</label>
                        <p class="yorum-p" style="font-weight: 700;"><br>Soru  : '.$question["question"].'</p>
                        <p class="yorum-p"><br>'.$question["qmsg"].'</p><!--Soru metni-->
                    </div>
                    <!------------------------------------------------------------------------------->
                    <hr/>
                    <!--Soruya bağlı cavaplar aşağıdaki gibi alt alta sıralanıcak-->
                    ';


                            if($allAnswers != null){
                                foreach ($allAnswers as $answer){
                                    $userType = $answer["userType"];
                                    $answererInfos = null;
                                    $answererEmail = null;
                                    $answererFaculty = null;
                                    if ($userType == 0){
                                        $answererInfos = $tableAnon->getAnon($answer["answererid"]);
                                        $answererEmail = $answererInfos ["Aemail"];
                                    }else{
                                        $answererInfos = $tableStudent->getStudent($answer["answererid"]);
                                        $answererEmail = $answererInfos ["Semail"];
                                        $facultyId = $answererInfos["facultyId"];
                                        $answererFacultyInfos = $tableFac->getFacultyId($facultyId);
                                        $answererFaculty = $answererFacultyInfos["fName"];
                                    }
                                    $textAnswer = $answer["answer"];
                                    $answerTime = $answer["time"];
                                    echo'<div class="yorum">
                                    <label>'.$answererEmail.'</label>
                                    <label style="font-size: 20px;display:'; if ($answererFaculty != 0){echo"block"; }else{echo"none";} echo';"> 🎓 </label><label class="yorum-p" style="font-weight: 650;">'; if ($answererFaculty != 0){echo $answererFaculty;} else{ echo("Anonim");} echo '</label> <!--sadece öğrenci ise bu kısım görünecek öğrenci ise kullanıcının fakültesi db den çekilecek ve şapka görünecek-->
                                    <label class="yorum-p" style="float: right;">'.$answerTime.'</label>
                                    <p class="yorum-p"><br>Cevap > '.$textAnswer.'</p><!--Kullanıcı olmayan kişilerde açık olmamalı-->
                                </div>';
                                }
                            }
                            else{
                                // null ise textbarla oynamıs burada //istersen hata yazdır
                            }
                    echo'
                    <!--------------------------------------------------------------------------------->
                    <div style="display: ';if (isset($_SESSION["kadi"])){echo"block"; }else{echo"none";} echo'" class="cont">
                        <form action="cevaplar.php?id='.$questionId.'" method="POST">
                            <textarea name="textarea-yorum"></textarea>
                            <input type="submit" name="textarea-yorum-button" value="Kaydet" class="user-button" style="margin-top:-10px"> 
                        </form>
                    </div>
                </div>
            </div>
        </body>
        <!--||Ömer Ulusoy Back-end||-->
        <!--||Hüseyin Mert Neyse Front-end||-->
    </html>
';?>