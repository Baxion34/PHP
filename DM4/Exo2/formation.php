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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Formation</title>
        <link rel="stylesheet" href="CSS/stylesheet.css"/>
    </head>
    <body>
        <header>
            <!-- Affichage du login de connexion -->
            <?php echo "<label>Connecté en tant que : ".$_SESSION['login']."</label>"; ?>
            <form method="post">
                <input class="deconnexion" type="submit" name="deconnexion" value="Déconnexion"/>
            </form>
        </header>
        <h1>Liste de cours :</h1>
        <ul>
            <li><a href="cours1.php">Cours n°1</a></li>
            <li><a href="cours2.php">Cours n°2</a></li>
        </ul>
        <br/>
        <a href="rapport.php"><input class="connexion" type="submit" name="rapport" value="Voir le rapport"/></a>
    </body>
</html>

<?php
    // Déconnexion lors de la pression sur le bouton de déconnexion.
    if(isset($_POST['deconnexion'])) {
        unset($_SESSION['login'], $_SESSION['password'], $_SESSION['tps']);
        header("Location: connexion.php");
    }
?>