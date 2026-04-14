<?php
session_start();
require 'db.php';

$sql = "SELECT v.*, u.nom_utilisateur AS utilisateur
        FROM ventes v
        JOIN utilisateurs u ON u.id_user = v.id_user
        ORDER BY v.date_vente DESC";

$stmt = $pdo->query($sql);
$ventes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ventes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Ventes</h2>

<table class="ticket-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Montant total</th>
            <th>Utilisateur</th>
            <th>Articles</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($ventes)): ?>
            <tr><td colspan="5">Aucune vente</td></tr>
        <?php else: ?>
            <?php foreach ($ventes as $v): ?>
                <tr>
                    <td><?= date("d/m/Y H:i", strtotime($v['date_vente'])) ?></td>
                    <td><?= number_format($v['montant_total'], 2, ',', ' ') ?> €</td>
                    <td><?= htmlspecialchars($v['utilisateur']) ?></td>
                    <td><?= $v['nb_articles'] ?></td>
                    <td><a href="vente_detail.php?id=<?= $v['id_vente'] ?>">détail</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
