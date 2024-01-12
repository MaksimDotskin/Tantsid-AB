<?php
require_once ('conf.php');
function Timer($item){ //meetod mis võtab objekt ja kustutab talle 2 sekondi parast
    ?>
    <script>
        setTimeout(function(){
            document.getElementById('<?php echo $item; ?>').style.display='none';
        }, 2000);
    </script>
    <?php
}

global $yhendus;
session_start();
if (isset($_REQUEST['okBtn'])){ //kui vajutame OK nuppu
    if (!empty($_POST['username']) && !empty($_POST['pass1']) && !empty($_POST['pass2'])) { //vaatame et kõik väljad on miite tühjad
        //eemaldame kasutaja sisestusest kahtlase pahna
        $username = htmlspecialchars(trim($_POST['username'])); //võtame nimi
        $pass1 = htmlspecialchars(trim($_POST['pass1'])); //parool
        $pass2 = htmlspecialchars(trim($_POST['pass2'])); //parooli kinnitamine

        $kask=$yhendus-> prepare("SELECT kasutaja FROM kasutaja WHERE kasutaja=?"); //vaatame et ei olnud konto sama nimega
        $kask->bind_param("s", $username);
        $kask->bind_result($kasutaja);
        $kask->execute();
        if (!$kask->fetch()) { //kui ei ole kontrollime et parool ja kinnitamine olid samad

            if ($pass2 == $pass1) {
                $cool = "superpaev";
                $krypt = crypt($pass1, $cool);//see kood koderib parool andmebasile
                //kontrollime kas andmebaasis on selline kasutaja ja parool
                $kask = $yhendus->prepare("insert into kasutaja(kasutaja,parool,onAdmin) values(?,?,0)"); //lisane uue konto
                $kask->bind_param("ss", $username, $krypt);
                //$kask->bind_result($kasutaja, $onAdmin);
                $kask->execute();

                $_SESSION['tuvastamine'] = 'misiganes'; //anname teadmised muutujate kohta
                $_SESSION['kasutaja'] = $username;
                $_SESSION['onAdmin'] = 0;

                header("location: kasutaja_leht.php"); //mürgitame kasutajha lehtele kui kõik on super
                $yhendus->close();
                exit();
//                ?>
<!--                    -->
<!--                <div id="regComplete">-->
<!--                    <span>Olete registreeritud</span>-->
<!--                    <a href="login.php">Logi sisse</a>-->
<!---->
<!--                </div>-->
<!--                --><?php
            }
            else{ //veateaded
                ?>
                <div id="notif1" class="notifications">
                    <span>Paroolid on mitte samad</span>
                    <?php Timer('notif1');?>
                </div>
                <?php
            }
        }
        else{
            ?>
            <div id="notif3" class="notifications">
                <span>Seeda nimi on juba võetud</span>
                <?php Timer('notif3');?>
            </div>
            <?php
        }
    }
    else{
        ?>
        <div id="notif2" class="notifications">
            <span>Tühjad väljad</span>
            <?php Timer('notif2');?>
        </div>
        <?php
    }
}



//admin-su2w8EgMrA/nU opilane-suyoLRfxperFE
    //kui on, siis loome sessiooni ja suuname
//    if ($kask->fetch()) {
//        $_SESSION['tuvastamine'] = 'misiganes';
//        $_SESSION['kasutaja'] = $login;
//        $_SESSION['onAdmin'] = $onAdmin;
//        if ($onAdmin==1) {
//            header("location: admin_leht.php");
//        }
//        else{
//            header("location: kasutaja_leht.php");
//        }
//        $yhendus->close();
//        exit();
//
//    } else {
//        echo "kasutaja $login või parool $krypt on vale";
//        $yhendus->close();
//    }

?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registreeris leht</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="log_regDiv">
    <h1>Registreeri</h1>
    <form action="" method="post">
        Nimi: <input type="text" name="username"><br>
        Parool: <input type="password" name="pass1"><br>
        Kinnitada Parool: <input type="password" name="pass2"><br>
        <input type="submit" value="Registreeri" name="okBtn">
        <br>
        <br>
        <span>Kas teil on juba konto?<a href="login.php"> Logi sisse</a></span>

    </form>
</div>

</body>
</html>
