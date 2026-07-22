<?php
session_start();
function sanitize(string $input): string {
    return htmlspecialchars(trim($input));
}

function redirectTo(string $url): void {
    header('Location: '.$url);
    die();
}

$data = $_POST;

$title = sanitize($data['titre'] ?? '');
$artist = sanitize($data['artiste'] ?? '');
$description = sanitize($data['description'] ?? '');
$img = sanitize($data['image'] ?? '');

$errors = [];

if(strlen($title) === 0) {
    $errors[] = "Le champs \"Titre de l'œuvre\" est vide";
}

if(strlen($artist) === 0) {
    $errors[] = "Le champs \"Auteur de l'œuvre\" est vide";
}

if(strlen($img) === 0) {
    $errors[] = "Le champs \"URL de l'image\" est vide";
}

if(!filter_var($img, FILTER_VALIDATE_URL)) {
   $errors[] = "Le champs \"URL de l'image\" n'est pas une URL valide"; 
}

if(strlen($description) < 3) {
    $errors[] = "Le champs \"Description\" doit au moins faire 3 charactères";
}

if(count($errors) > 0) {
    $_SESSION['messages'] ??= [];
    $_SESSION['messages'][] = [
        'type' => 'error',
        'texte' => 'Le formulaire ne peut pas traité',
        'details' => implode("\n\r", $errors)
    ];
    redirectTo('/ajouter.php');
}

redirectTo('/');