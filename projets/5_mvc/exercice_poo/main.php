<?php
require_once 'src/DBConnect.php';

$dbConnect = new DBConnect(
    database: 'db',
    user: 'formation-user',
    password: 'formation-password'
);

$db = $dbConnect->getPDO();

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    if($line === "list") {
        echo "affichage de la liste\n";
    }
}