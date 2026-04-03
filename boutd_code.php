<?php
session_start();
require_once 'db.php';

// Vérifier connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* ===========================
   RECHERCHE
=========================== */
$recherche = "";
if (isset($_GET['recherche'])) {
    $recherche = trim($_GET['recherche']);
}

/* ===========================
   REQUÊTE PRODUITS
=========================== */
$sql = "SELECT * FROM produits
        WHERE nom_produit LIKE :recherche
        ORDER BY nom_produit ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':recherche' => "%$recherche%"
]);

$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>