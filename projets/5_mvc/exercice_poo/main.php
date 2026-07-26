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

    $matches = [];
    match(true) {
        (bool) preg_match('/create ([a-zA-Z0-9]+), (.+@.+), ([0-9]+)/', $line, $matches) => $command->create($matches[1], $matches[2], $matches[3]),
        (bool) preg_match('/detail ([0-9]+)/', $line, $matches) => $command->detail($matches[1]),
        $line === "list" => $command->list(),
        default => "",
    };
    echo "\n";
}