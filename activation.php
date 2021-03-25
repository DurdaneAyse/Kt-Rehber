<?php
require_once ("AllConnections.php");
if (isset($_GET['code']) && isset($_GET['usrmode'])){
    if ($_GET['usrmode'] == "student"){
        if ($tableStudent->loginActivateStudent($_GET['code'])){
            echo "Aktivaston başarılı tebrikler";
        }else{
            echo "Aktivasyon başarılı degil";
        }
    }else if ($_GET['usrmode'] == "anon"){
        if ($tableAnon->loginActivateAnon($_GET['code'])){
            echo "Aktivaston başarılı tebrikler";
        }else{
            echo "Aktivasyon başarılı degil";
        }
    }else{
        echo "Kardeşim bozmuşun bişeyleri aktif etmedim seni hadi yallah arabistana";
    }
}else{
    echo "Kardeşim bozmuşun bişeyleri aktif etmedim seni hadi yallah arabistana";
}
header("Location: index.php");