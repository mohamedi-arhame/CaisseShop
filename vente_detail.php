<?php
session_start();
require 'db.php';

// Sécurité connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

/* ================= INFOS VENTE ================= */
$sqlVente = "
SELECT 
    v.*, 
    u.nom_utilisateur
FROM ventes v
JOIN utilisateurs u ON v.id_user = u.id_user
WHERE v.id_vente = ?
";
$stmt = $pdo->prepare($sqlVente);
$stmt->execute([$id]);
$vente = $stmt->fetch();

// Si vente inexistante
if (!$vente) {
    header("Location: ventes.php");
    exit;
}

/* ================= DETAILS PRODUITS ================= */
$sqlDetails = "
SELECT 
    p.nom_produit,
    d.prix_unitaire,
    d.quantite,
    d.total_ligne
FROM ventes_details d
JOIN produits p ON d.id_produit = p.id_produit
WHERE d.id_vente = ?
";
$stmt = $pdo->prepare($sqlDetails);
$stmt->execute([$id]);
$details = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="produits-card">

    <div class="produits-title">Détail de vente</div>

    <!-- Bloc infos vente (sans style inline) -->
    <div class="produits-card">
        <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($vente['date_vente'])) ?></p>
        <p><strong>Heure :</strong> <?= date('H:i', strtotime($vente['date_vente'])) ?></p>
        <p><strong>Utilisateur :</strong> <?= $vente['nom_utilisateur'] ?></p>
        <p><strong>Montant total :</strong> <?= number_format($vente['montant_total'],2) ?> €</p>
        <p><strong>Nombre d'articles :</strong> <?= $vente['nb_articles'] ?></p>
    </div>

    <table class="ticket-table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($details as $d): ?>
            <tr>
                <td><?= $d['nom_produit'] ?></td>
                <td><?= number_format($d['prix_unitaire'],2) ?> €</td>
                <td><?= $d['quantite'] ?></td>
                <td><?= number_format($d['total_ligne'],2) ?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="ventes.php" class="btn-small btn-blue">Retour</a>

</div>

</body>
</html>