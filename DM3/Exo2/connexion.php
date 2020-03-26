<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <link rel="stylesheet" href="stylesheet.css"/>
    </head>
    <body>
        <form method="post">
            <table>
                <tr>
                    <td><b>Login :</b>
                    <input type="text" name="login" placeholder="Identifiant" required /></td>
                </tr>
                <tr>
                    <td><b>Mot de passe :</b>
                    <input type="password" name="passwd" placeholder="Mot de passe" required /></td>
                </tr>
                <tr>
                    <td><input class="connexion" type="submit" name="connexion" value="Connexion"/></td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php
    $login_admin = "admin";
    $mdp_admin = "admin";

    if(isset($_POST['connexion'])) {
        if($_POST['login'] == $login_admin && $_POST['passwd'] == $mdp_admin) {
            session_start();
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['passwd'];
            $_SESSION['tps'] = time();
            header("Location: formation.php");
        } else {
            echo "<h1 style=\"color:red\">Mauvaise combinaison login/mdp.</h1>";
        }
    }
?>