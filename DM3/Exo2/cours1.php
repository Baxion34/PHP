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

    if (!isset($_COOKIE['counter'])) {
        $cookie=1;
        setcookie('counter', $cookie);
    } else {
        $cookie = ++$_COOKIE['counter'];
        setcookie('counter', $cookie);
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
            <p>Vous avez visité cette page <?= $cookie; ?> fois.</p>
        </header>

        <div class="container" id="page">
            <div id="box-contenu">
                <div id="contenu">
                    <h1>Descriptif du cours :</h1>
                    <!--Texte généré aléatoirement-->
                    <p>Sed (saepe enim redeo ad Scipionem, cuius omnis sermo erat de amicitia) querebatur, quod omnibus in rebus homines diligentiores essent; capras et oves quot quisque haberet, dicere posse, amicos quot haberet, non posse dicere et in illis quidem parandis adhibere curam, in amicis eligendis neglegentis esse nec habere quasi signa quaedam et notas, quibus eos qui ad amicitias essent idonei, iudicarent. Sunt igitur firmi et stabiles et constantes eligendi; cuius generis est magna penuria. Et iudicare difficile est sane nisi expertum; experiendum autem est in ipsa amicitia. Ita praecurrit amicitia iudicium tollitque experiendi potestatem.</p>
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
        $cookie = --$_COOKIE['counter'];
        setcookie('counter', $cookie);
        header("Location: connexion.php");
    }
?>