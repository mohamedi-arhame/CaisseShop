<?php
session_start();
require 'db.php';

if (empty($_GET['id'])) {
    die("ID manquant");
}

$id = $_GET['id'];

$sql = "SELECT v.*, u.nom_utilisateur AS utilisateur
        FROM ventes v
        JOIN utilisateurs u ON u.id_user = v.id_user
        WHERE v.id_vente = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$vente = $stmt->fetch();

if (!$vente) {
    die("Vente introuvable");
}

$sql = "SELECT l.*, p.nom_produit
        FROM ventes_lignes l
        JOIN produits p ON p.id_produit = l.id_produit
        WHERE l.id_vente = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Détail vente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Détail de vente</h2>

<p>Date : <?= date("d/m/Y H:i", strtotime($vente['date_vente'])) ?></p>
<p>Utilisateur : <?= htmlspecialchars($vente['utilisateur']) ?></p>
<p>Montant total : <?= number_format($vente['montant_total'], 2, ',', ' ') ?> €</p>
<p>Articles : <?= $vente['nb_articles'] ?></p>

<table class="ticket-table">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Prix</th>
            <th>Qté</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($lignes as $l): ?>
            <tr>
                <td><?= htmlspecialchars($l['nom_produit']) ?></td>
                <td><?= number_format($l['prix_unitaire'], 2, ',', ' ') ?> €</td>
                <td><?= $l['quantite'] ?></td>
                <td><?= number_format($l['prix_unitaire'] * $l['quantite'], 2, ',', ' ') ?> €</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="ventes.php">Retour</a>

</body>
</html>
