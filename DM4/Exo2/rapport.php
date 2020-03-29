<?php
    include "SQL/fonctions-sql.php";
    $con = connect();
    $res = query($con, "SELECT * FROM users");  
    finish($con);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Rapport de connexions</title>
        <link rel="stylesheet" href="CSS/stylesheet.css"/>
    </head>
    <body>
        <h1>Rapport de connexions</h1>
        <table width=40%>
            <tr>
                <th>Dernière activité</th>
                <th>Utilisateur</th>
                <th>@IP</th>
                <th>Accès cours n°1</th>
                <th>Accès cours n°2</th>
            </tr>
            <?php
                /* Affichage des informations de visite des utilisateurs qui ont visités une
                 * des deux pages de cours au moins 1 fois.
                 */
                for($i=0 ; $i<mysqli_num_rows($res) ; $i++){
                    $ligne = mysqli_fetch_array($res);
                    if($ligne["nb_Cours1"] > 0 || $ligne["nb_Cours2"] > 0) {
            ?>
                <tr>
                    <td><?=$ligne["date-heure_visite"] ?></td>
                    <td><?=$ligne["login"] ?></td>
                    <td><?=$ligne["IP"] ?></td>
                    <td><?=$ligne["nb_Cours1"] ?></td>
                    <td><?=$ligne["nb_Cours2"] ?></td>
                </tr>
            <?php }} ?>
        </table>
        <footer>
            <a href="formation.php" class="retour">Retour</a>
        </footer>
    </body>
</html>