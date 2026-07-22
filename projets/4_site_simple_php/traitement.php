<?php
session_start();
function sanitize(string $input): string {
    return htmlspecialchars(trim($input));
}

function redirectTo(string $url): void {
    header('Location: '.$url);
    die();
}

function addMsg($type, $texte, $details = "") {
    $_SESSION['messages'] ??= [];
    $_SESSION['messages'][] = [
        'type' => $type,
        'texte' => $texte,
        'details' => $details
    ];
}

$pdo = include 'includes/bdd.php';

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
    addMsg(
        'error', 
        'Le formulaire ne peut pas traité', 
        implode("\n\r", $errors)
    );
    redirectTo('/ajouter.php');
}

try {
    $sql = "INSERT INTO oeuvres (title, artist, description, img) VALUES (?, ?, ?, ?);";
    $request = $pdo->prepare($sql);
    $request->execute([
        $title,
        $artist,
        $description,
        $img
    ]);
} catch(PDOException $e) {
    addMsg('error', 'Une erreur est survenue pendant le traitement', $e->getMessage());
    redirectTo('/ajouter.php');
}

addMsg('success', 'Oeuvre ' . $title . ' ajoutée !');
redirectTo('/');