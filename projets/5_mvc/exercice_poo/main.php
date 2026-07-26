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
    $line = readline("Entrez votre commande (list, detail, create, delete, quit) : ");

    $matches = [];
    match(1) {
        preg_match('/^create ([a-zA-Z0-9]+), (.+@.+), ([0-9]+)$/', $line, $matches) => $command->create($matches[1], $matches[2], $matches[3]),
        preg_match('/^detail ([0-9]+)$/', $line, $matches) => $command->detail($matches[1]),
        preg_match('/^delete ([0-9]+)$/', $line, $matches) => $command->delete($matches[1]),
        preg_match('/^list$/', $line) => $command->list(),
        preg_match('/^quit$/', $line) => $command->quit(),
        default => "",
    };
    echo "\n";
}