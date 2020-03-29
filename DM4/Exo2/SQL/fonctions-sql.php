<?php
    // Connexion à la base de données mySQL
    function connect(){
        return mysqli_connect("127.0.0.1", "root", "", "sessions");
    }

    // Permet d'effectuer une requête SQL
    function query($con, $req){
        return mysqli_query($con, $req);
    }

    // Termine une connexion vers une base de données mySQL
    function finish($con){
        mysqli_close($con);
    }
?>