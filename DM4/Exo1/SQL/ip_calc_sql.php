<?php
    // Connexion à la base de données mySQL
    function connect(){
        return mysqli_connect("127.0.0.1", "root", "", "ip_calc");
    }

    // Permet d'effectuer une requête SQL
    function query($con, $req){
        return mysqli_query($con, $req);
    }

    // Libère la licence actuelle utilisée
    function resetLicence($con, $id){
        query($con, "UPDATE licences SET Etat=0 WHERE ID = ".$id);
    }

    // Termine une connexion vers une base de données mySQL
    function finish($con){
        mysqli_close($con);
    }
?>