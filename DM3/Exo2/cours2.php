<?php
    session_start();

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

    if (!isset($_COOKIE['counter2'])) {
        $cookie2=1;
        setcookie('counter2', $cookie2);
    } else {
        $cookie2 = ++$_COOKIE['counter2'];
        setcookie('counter2', $cookie2);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cours1</title>
        <link rel="stylesheet" href="stylesheet.css"/>
    </head>
    <body>
        <header>
            <!-- Affichage du login de connexion -->
            <?php echo "<label>Connecté en tant que : ".$_SESSION['login']."</label>"; ?>
            <form method="post">
                <input class="deconnexion" type="submit" name="deconnexion" value="Déconnexion"/>
            </form>
            <p>Vous avez visité cette page <?= $cookie2; ?> fois.</p>
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
        $cookie2 = --$_COOKIE['counter2'];
        setcookie('counter2', $cookie2);
        header("Location: connexion.php");
    }
?>