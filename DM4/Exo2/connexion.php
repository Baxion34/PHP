<?php
    include "SQL/fonctions-sql.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <link rel="stylesheet" href="CSS/stylesheet.css"/>
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
    // Connexion à la BDD
    $con=connect();
    if(isset($_POST['connexion'])) {
        $login = $_POST['login'];
        $mdp = $_POST['passwd'];
        // On stocke le résultat retourné par la requête SQL.
        $res = query($con, "SELECT * FROM users WHERE login = '$login' AND passwd = '$mdp'");

        // Si le résultat stocké n'est pas nul, on démarre une session
        if(mysqli_num_rows($res) != 0){
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $mdp;
            $_SESSION['tps'] = time();
            header("Location: formation.php");
        } else {
            echo "<h1 style=\"color:red\">Mauvaise combinaison login/mdp.</h1>";
        }
    }
    finish($con);
?>