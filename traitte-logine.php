<?php
session_start();
require_once 'db.php';

$erreur = "";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    $erreur = "Requête invalide";
    $_SESSION['error'] = $erreur;

    header("Location: login.php");
    exit;
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {

    $erreur = "Champs manquants";
    $_SESSION['error'] = $erreur;

    header("Location: login.php");
    exit;
}

// Récupérer les données du formulaire
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {

    $erreur = "Veuillez remplir tous les champs";
    $_SESSION['error'] = $erreur;

    header("Location: login.php");
    exit;
}

// 5. Vérifier si l'utilisateur existe dans la base
$sql = "SELECT * FROM utilisateurs WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

// 6.
if (!$user) {

    $erreur = "Vous n'êtes pas inscrit sur notre site";
    $_SESSION['error'] = $erreur;

    header("Location: login.php");
    exit;
}

// 7. Vérifier le mot de passe
if (!password_verify($password, $user['mot_de_passe'])) {

    $erreur = "Mot de passe incorrect";
    $_SESSION['error'] = $erreur;

    header("Location: login.php");
    exit;
}

// 8. Si tout est correct → créer la session
$_SESSION['user_id'] = $user['id_user'];
$_SESSION['email'] = $user['email'];
$_SESSION['nom'] = $user['nom_utilisateur'];

// 9. Redirection vers la caisse
header("Location: index.php");
exit;
