<?php
require_once ('conf.php');
session_start();
// punktide lisamine
if (isset($_REQUEST["heatants"])){
    global $yhendus;
    $kask=$yhendus->prepare("update tantsid set punktid=punktid+1 where id=?");
    $kask->bind_param("i",$_REQUEST["heatants"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}
// minus punkt
if (isset($_REQUEST["pahatants"])){
    global $yhendus;
    $kask=$yhendus->prepare("update tantsid set punktid=punktid-1 where id=?");
    $kask->bind_param("i",$_REQUEST["pahatants"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// kommentaarimine lisamine
if(isset($_REQUEST["komment"])){
    if(!empty($_REQUEST["uuskomment"])){
        global $yhendus;
        $kask = $yhendus->prepare("UPDATE tantsid SET kommentaarid=CONCAT(kommentaarid, ?,', ') WHERE id=?");
        $kommentplus=$_REQUEST["uuskomment"];
        $kask->bind_param("si", $kommentplus, $_REQUEST["komment"]);
        $kask->execute();
        header("Location: $_SERVER[PHP_SELF]");
        $yhendus->close();

    }
}
//lisamine uue paari
if (isset($_REQUEST["paarinimi"]) && !empty($_REQUEST["paarinimi"])){
    global $yhendus;
    $kask=$yhendus->prepare("insert into tantsid(tantsupaar,ava_paev_) values(?,NOW())");
    $kask->bind_param("s",$_REQUEST["paarinimi"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tantsud tähtedega</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<h1 class="mainH1">Tantsud tähtedega</h1>
<nav>
    <?php
    if(isset($_SESSION['kasutaja'])){
        ?>
        <h1  id="h1">Tere, <?= $_SESSION['kasutaja'] ?></h1>
        <a href="logout.php">Logi välja</a>
        <?php
        echo "<ul>";
        if (isAdmin()) { //naitame lingid lehtele ainult adminile
            echo "<li>";
            echo '<a href="kasutaja_leht.php" class="adminNavA">Kasutaja</a>';
            echo "</li>";

            echo "<li>";
            echo '<a href="admin_leht.php" class="adminNavA">Admin</a>';
            echo "</li>";
        }

    }
    //kui  oleme admin
    else if(!isset($_SESSION['kasutaja'])) { ?>
        <a href="login.php">Logi sisse</a>
        <a href="registreeri.php">Registreeri</a>
    <?php }
    echo "</ul>";
    ?>
</nav>

<?php
if(isset($_SESSION['kasutaja'])){
    ?>
    <h2>Kasutajate leht</h2>
    <table>
        <tr>
            <th>Tantsupaari nimi</th>
            <th>Punktid</th>
            <th>Ava paev</th>

            <?php if(isAdmin()){
                ?>
                <th>kommentaarid</th>
                <?php
            }
            else{
                ?>
                <th COLSPAN="2">Kommentaarid</th>
                <?php
            }
            if (!isAdmin()){
            ?><th></th><th></th>
            <?php } ?>


        </tr>
        <?php
        global $yhendus;
        $kask=$yhendus->prepare("select id,tantsupaar,punktid,ava_paev_,kommentaarid from tantsid  where avalik=1");
        $kask->bind_result($id,$tantsupaar,$punktid,$paev,$komment);
        $kask->execute();

        while($kask->fetch()){
            echo "<tr>";
            $tantsupaar=htmlspecialchars($tantsupaar);
            echo "<td>".$tantsupaar."</td>";
            echo "<td>".$punktid."</td>";
            echo "<td>".$paev."</td>";
            echo "<td>".$komment."</td>";


            //kommentaari lisamine
        if (!isAdmin()){?>
            <td>
            <form action='?'>
                <input type='hidden'  value='<?php echo $id; ?>' name='komment'>
                <input type='text' name='uuskomment' id='uuskomment'>
                <input type='submit' value='OK'>
            </form>
            </td>

            <?php
        }
            if (!isAdmin()){
                echo "<td><a href='?heatants=$id'>Lisa +1punkt</a></td>"; //naitame ainult adminile
                echo "<td><a href='?pahatants=$id'>Kustuta -1punkt</a></td>";
            }

            echo "</tr>";
        }
        ?>
        <div id="newPaarDiv">
        <form action="?" method="post">
            <label for="paarinimi">Lisa uus paar</label>
            <input type="text" name="paarinimi" id="paarinimi">
            <input type="submit" value="Lisa paar">
        </form>
        </div>
    </table>
    <?php
}

function isAdmin(){
    return isset($_SESSION['onAdmin']) && $_SESSION['onAdmin'];
}
?>
</body>
</html>
