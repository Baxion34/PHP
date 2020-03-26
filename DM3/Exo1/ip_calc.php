<?php
// Détermine la classe d'une @IP classfull selon son premier octet.
function classIP($octets) {
    if($octets[0] > 0 && $octets[0] < 128) {
        $classe="A";
    } else if($octets[0] > 127 && $octets[0] < 192) {
        $classe="B";
    } else if($octets[0] > 191 && $octets[0] < 224) {
        $classe="C";
    } else if($octets[0] > 223 && $octets[0] < 240) {
        $classe="D";
    } else if($octets[0] > 239 && $octets[0] < 256){
        $classe="E";
    }
    return $classe;
}

// Transforme le CIDR (/X) en masque en décimale pointée X.X.X.X.
function CIDRtoMask($int) {
    return long2ip(-1 << (32 - (int)$int));
}

// Convertie une adresse IP décimale pointée en binaire pointée avec 8 bits pour chaque octet.
function DecTo8Bin($ip) {
    $bin = decbin(ip2long($ip));

    // Ajout de zeros à l'avant si l'adresse IP binaire possède moins de 32 bits.
    if(strlen($bin) < 32) {
        $bin = ajoutZerosBin($bin);
    }

    // Sépare les octets (tous les 8 bits) par un '.'.
    $bin = wordwrap($bin, 8, '.', true);
    return $bin;
}

/* Permet d'ajouter des '0' qui ne sont pas affichés en 
 * binaire par la fonction decbin().
 */
function ajoutZerosBin($ip) {
    if (($result = (32 - strlen($ip))) > 0) {
        return str_repeat("0", $result).$ip;
    }
}

// Convertie une adresse IP binaire pointée en décimale pointée.
function Bin8ToDec($ip) {    
    $dec = long2ip(bindec($ip));
    return $dec;
}

// Vérifie qu'un nombre est entre deux autres nombres.
function inRange($nombre, $min, $max){
    if($nombre >= $min && $nombre <= $max){
        return true;
    }
    return false;
}

// Vérifie qu'une adresse ip (format décimal pointé) est valide.
function isAdresseIpValide($ip){
    $retour = true;
    foreach(explode(".", $ip) as $octet){
        //Si un octet n'est pas entre 0 et 255
        if(!inRange($octet, -1, 256)){
            $retour = false;
        }
    }
    return $retour;
}
?>
