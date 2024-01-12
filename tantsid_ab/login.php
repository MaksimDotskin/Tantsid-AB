<?php
require_once ('conf.php');
global $yhendus;
session_start();

function Timer($item){
    ?>
    <script>
        setTimeout(function(){
            document.getElementById('<?php echo $item; ?>').style.display='none';
        }, 2000);
    </script>
    <?php
}


//kontrollime kas väljad  login vormis on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $cool="superpaev";
    $krypt = crypt($pass, $cool);
    //kontrollime kas andmebaasis on selline kasutaja ja parool
    $kask=$yhendus-> prepare("SELECT kasutaja, onAdmin FROM kasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $krypt);
    $kask->bind_result($kasutaja, $onAdmin);
    $kask->execute();
    //kui on, siis loome sessiooni ja suuname
    if ($kask->fetch()) {
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $login;
        $_SESSION['onAdmin'] = $onAdmin;
        if ($onAdmin==1) {
            header("location: admin_leht.php");
        }
        else{
            header("location: kasutaja_leht.php");
        }
        $yhendus->close();
        exit();

    } else {
        ?>
        <div id="notif4" class="notifications">
            <span>Kasutaja <?php echo $login; ?> või parool <?php echo $krypt; ?> on vale</span>

            <?php Timer('notif4');?>
        </div>
        <?php

        $yhendus->close();
    }
}
function isAdmin(){
    return isset($_SESSION['onAdmin']) && $_SESSION['onAdmin'];
}
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login leht</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="log_regDiv">


    <h1>Sisse logimine</h1>
    <form action="" method="post">
        Login: <input type="text" name="login"><br>
        Parool: <input type="password" name="pass"><br>
        <input type="submit" value="Logi sisse">
        <br>
        <br>

        <span>Kas ei ole registreeritud?<a href="registreeri.php"> Registreeri</a></span>
    </form>
</div>
</body>
</html>
