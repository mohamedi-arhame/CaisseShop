<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Non autorisé");
}

$panier = json_decode(file_get_contents("php://input"), true);

if (!$panier || count($panier) == 0) {
    exit("Panier vide");
}

$id_user = $_SESSION['user_id'];

$pdo->beginTransaction();

try {

    $montant_total = 0;
    $nb_articles = 0;

    foreach ($panier as $p) {
        $montant_total += $p['prix'] * $p['qte'];
        $nb_articles += $p['qte'];
    }

    // INSERT VENTE
    $stmt = $pdo->prepare("
        INSERT INTO ventes (date_vente, montant_total, nb_articles, id_user)
        VALUES (NOW(), ?, ?, ?)
    ");
    $stmt->execute([$montant_total, $nb_articles, $id_user]);

    $id_vente = $pdo->lastInsertId();

    // INSERT DETAILS
    $stmtDetail = $pdo->prepare("
        INSERT INTO ventes_details
        (id_vente, id_produit, prix_unitaire, quantite, total_ligne)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($panier as $p) {
        $total = $p['prix'] * $p['qte'];

        $stmtDetail->execute([
            $id_vente,
            $p['id'],
            $p['prix'],
            $p['qte'],
            $total
        ]);
    }

    $pdo->commit();

    echo "OK|" . $id_vente;

} catch (Exception $e) {
    $pdo->rollBack();
    echo $e->getMessage();
}