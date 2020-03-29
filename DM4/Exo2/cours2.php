<?php
    include "SQL/fonctions-sql.php";

    $con = connect();
    session_start();
    $res = query($con, "SELECT * FROM users WHERE login='".$_SESSION['login']."' AND passwd='".$_SESSION['password']."'");
    $ligne = mysqli_fetch_array($res);

    // Redirection à la page de login si non connecté.
    if (!isset($_SESSION['login'], $_SESSION['password'])) {
        header("Location: connexion.php");
        exit;
    }

    // Déconnexion automatique au bout de 10 minutes d'inactivité.
    if(isset($_SESSION['login']) && (time() - $_SESSION['tps'] > 10*60)) {
        unset($_SESSION['login'], $_SESSION['password'], $_SESSION['tps']);
        header("Location: connexion.php");
    } else {
        $_SESSION['tps'] = time();
    }

    // Obtention de la date et heure quand l'utilisateur arrive sur la page
    date_default_timezone_set('Europe/Paris');
    $date=date("Y-m-d H:i:s");

    // @IP de l'utilisateur
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Mise à jour des champs date/heure, IP et nb_Cours2 de la BDD:
    query($con, "UPDATE users SET `date-heure_visite`='$date', IP='$ip', nb_Cours2='".strval($ligne['nb_Cours2']+1)."' WHERE login='".$_SESSION['login']."' AND passwd='".$_SESSION['password']."'");
    /*if (!isset($_COOKIE['counter'])) {
        $cookie=1;
        setcookie('counter', $cookie);
    } else {
        $cookie = ++$_COOKIE['counter'];
        setcookie('counter', $cookie);
    }*/
    finish($con);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cours2</title>
        <link rel="stylesheet" href="CSS/stylesheet.css"/>
    </head>
    <body>
        <header>
            <!-- Affichage du login de connexion -->
            <?php echo "<label>Connecté en tant que : ".$_SESSION['login']."</label>"; ?>
            <form method="post">
                <input class="deconnexion" type="submit" name="deconnexion" value="Déconnexion"/>
            </form>
            <p>Vous avez visité cette page <?=strval($ligne['nb_Cours2']+1) ?> fois.</p>
        </header>

        <div class="container" id="page">
            <div id="box-contenu">
                <div id="contenu">
                    <h1>Descriptif du cours :</h1>
                    <!--Texte généré aléatoirement-->
                    <p>Raptim igitur properantes ut motus sui rumores celeritate nimia praevenirent, vigore corporum ac levitate confisi per flexuosas semitas ad summitates collium tardius evadebant. et cum superatis difficultatibus arduis ad supercilia venissent fluvii Melanis alti et verticosi, qui pro muro tuetur accolas circumfusus, augente nocte adulta terrorem quievere paulisper lucem opperientes. arbitrabantur enim nullo inpediente transgressi inopino adcursu adposita quaeque vastare, sed in cassum labores pertulere gravissimos.</p>
                </div>
            </div>
        </div>

        <footer>
            <a href="formation.php" class="retour">Retour</a>
        </footer>
    </body>
</html>

<?php
    // Déconnexion lors de la pression sur le bouton de déconnexion.
    if(isset($_POST['deconnexion'])) {
        unset($_SESSION['login'], $_SESSION['password'], $_SESSION['tps']);
        // $cookie = --$_COOKIE['counter'];
        // setcookie('counter', $cookie);
        header("Location: connexion.php");
    }
?>