<?php
session_start();
require 'db.php';

if (empty($_POST['panier'])) {
    echo "Panier vide";
    exit;
}

$panier = json_decode($_POST['panier'], true);

if (!is_array($panier)) {
    echo "Erreur panier";
    exit;
}

$montant = 0;
$nb_articles = 0;

foreach ($panier as $item) {
    $montant += $item['prix'] * $item['qte'];
    $nb_articles += $item['qte'];
}

$sql = "INSERT INTO ventes (date_vente, id_user, montant_total, nb_articles)
        VALUES (NOW(), ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id'], $montant, $nb_articles]);

$id_vente = $pdo->lastInsertId();

foreach ($panier as $item) {

    $total_ligne = $item['prix'] * $item['qte'];

    $sql = "INSERT INTO ventes_details (id_vente, id_produit, quantite, prix_unitaire, total_ligne)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $id_vente,
        $item['id'],
        $item['qte'],
        $item['prix'],
        $total_ligne
    ]);

    $sql = "UPDATE produits SET stock = stock - ? WHERE id_produit = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$item['qte'], $item['id']]);
}

echo "OK";
