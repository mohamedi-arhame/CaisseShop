<?php
session_start();

$host = 'localhost';
$dbname = 'caisseshop';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function login($pdo, $username, $password) {
    $sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = :u";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['u' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Pour tester facilement : mot de passe en clair (à remplacer par password_hash plus tard)
    if ($user && $password === $user['mot_de_passe']) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['nom_utilisateur'];
        return true;
    }
    return false;
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
