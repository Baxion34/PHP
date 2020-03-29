<?php
    require "ip_calc.php";
    include "SQL/ip_calc_sql.php";
    /* Création d'un cookie qui bloque l'utilisation de l'application au bout
     * de 3 utilisations et redirige vers une page d'erreur.
     
    if (!isset($_COOKIE['utilisation'])) {
        $cookie = 0;
        setcookie('utilisation', $cookie);
    } else {
        $cookie = ++$_COOKIE['utilisation'];
        setcookie('utilisation', $cookie);
        if($cookie > 3) {
            header("Location: max_utilisation.html");
            exit();
        }
    }*/
    $acces = true;
    if(isset($_POST['calcul'])) {
        if(isAdresseIpValide($_POST['IP']) && inRange($_POST['Masque'], 1, 32)) {
            $con = connect();
            $res = query($con, "SELECT ID FROM licences WHERE Etat=0");
            
            $octets = explode('.', $_POST['IP']);
            $classe = classIP($octets);
            
            $masque = CIDRtoMask($_POST['Masque']);
            $wildcard = long2ip( ~ip2long($masque));

            $reseau_bin = DecTo8Bin($_POST['IP']) & DecTo8Bin($masque);
            $reseau = Bin8ToDec($reseau_bin);

            $hosts = pow(2, (32 - $_POST['Masque'])) - 2;
            $diffusion = long2ip(ip2long($reseau)+$hosts+1);
            $host_min = long2ip(ip2long($reseau)+1);
            $host_max = long2ip(ip2long($reseau)+$hosts);

            if(mysqli_num_rows($res) == 0){ // 3 licences utilisées
                $acces = false;
            } else {
                $ligne = mysqli_fetch_array($res);
                query($con, "UPDATE licences SET Etat=1 WHERE ID = ".$ligne["ID"]);
                $count = mysqli_num_rows(query($con, "SELECT ID FROM licences WHERE Etat=1"));
            }
            mysqli_free_result($res);
            finish($con);
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>IP CALC</title>
</head>
<body>
<?php
    // Si des licences sont dispo, on affiche le calculateur d'IP.
    if($acces) { 
?>
    <h1>IP Calculator</h1>
    <form method="post">
        <table>
            <tr>
                <td><b><label>Adresse IP :</label></b></td>
                <td><b><label>Masque :</label></b></td>
            </tr>
            <tr>
                <td><input type="text" name="IP" placeholder="192.168.0.1" required /> /</td>
                <td><input type="text" name="Masque" placeholder="24" required /></td>
            </tr>
            <tr>
                <td><input type="submit" name="calcul" value="Calculer" onclick="confirmExit()"/></td>
            </tr>
        </table>
    </form>
    <br/>
    <table style="width:30%">
        <?php
            /* Fonction isset() permettant de réaliser les étapes suivantes (calculs)
             * uniquement après avoir confirmé/envoyé les informations (@IP et Masque) au formulaire.
             */
            if(isset($_POST['calcul'])) {
                if(isAdresseIpValide($_POST['IP']) && inRange($_POST['Masque'], 1, 32)) {
                    // Affichage du texte et des éléments calculés dans une table.
                    echo "<tr><td>Nombre d'utilisation : </td><td>".$count." licence(s) active(s).</td></tr>";
                    echo "<tr><td style=\"color:red\">Adresse IP de classe ".$classe."</td></tr>";
                    echo "<tr><td>Adresse : </td><td>".$_POST['IP']."</td><td>".DecTo8Bin($_POST['IP'])."</td></tr>";
                    echo "<tr><td>Masque : </td><td>".$masque." = ".$_POST['Masque']."</td><td>".DecTo8Bin($masque)."</td></tr>";
                    echo "<tr><td>Wildcard : </td><td>".$wildcard."</td><td>".DecTo8Bin($wildcard)."</td></tr>";
                    echo "<tr><td>=></td></tr>";
                    echo "<tr><td>Réseau : </td><td>".$reseau."</td><td>".$reseau_bin."</td></tr>";
                    echo "<tr><td>Diffusion : </td><td>".$diffusion."</td><td>".DecTo8Bin($diffusion)."</td></tr>";
                    echo "<tr><td>Hôte min : </td><td>".$host_min."</td><td>".DecTo8Bin($host_min)."</td></tr>";
                    echo "<tr><td>Hôte max : </td><td>".$host_max."</td><td>".DecTo8Bin($host_max)."</td></tr>";
                    echo "<tr><td>Hôtes par réseau : </td><td>".$hosts."</td></tr>";

                    // Affiche un message lorsque l'adresse calculée est une adresse privée.
                    if($octets[0] == 10) {
                        echo "<tr><td style=\"color:blue\">Internet privé</td></tr>";
                    } else if($octets[0] == 172 && ($octets[1] >= 16 && $octets[1] <= 31)) {
                        echo "<tr><td style=\"color:blue\">Internet privé</td></tr>";
                    } else if($octets[0] == 192 && $octets[1] == 168) {
                        echo "<tr><td style=\"color:blue\">Internet privé</td></tr>";
                    }
                } else {
                    /*$cookie = --$_COOKIE['utilisation'];
                    setcookie('utilisation', $cookie);*/
                    echo "<p>Format de l'adresse IP ou du masque invalide.</p>";
                }
            }
        } else {
        ?>
            <h1>Aucune licence disponible actuellement, veuillez réessayer plus tard.</h1>
        <?php } ?>
    </table>
</body>
</html>