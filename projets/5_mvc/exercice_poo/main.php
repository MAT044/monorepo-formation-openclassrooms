<?php
require_once 'src/DBConnect.php';
require_once 'src/ContactManager.php';
require_once 'src/Contact.php';
require_once 'src/Command.php';

$dbConnect = new DBConnect(
    database: 'db',
    user: 'formation-user',
    password: 'formation-password'
);

$pdo = $dbConnect->getPDO();

$contactManager = new ContactManager($pdo);

$command = new Command($contactManager);

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    if($line === "list") {
        $command->list();
    }
}