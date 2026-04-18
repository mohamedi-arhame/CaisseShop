<?php
session_start();
require 'db.php';

// Vérifier connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* ================= FILTRE ================= */
$filtre = $_GET['filtre'] ?? 'tout';
$where = "";

switch($filtre){
    case 'jour':
        $where = "WHERE DATE(v.date_vente) = CURDATE()";
        break;

    case 'semaine':
        $where = "WHERE YEARWEEK(v.date_vente, 1) = YEARWEEK(CURDATE(), 1)";
        break;

    case 'mois':
        $where = "WHERE MONTH(v.date_vente) = MONTH(CURDATE())
                  AND YEAR(v.date_vente) = YEAR(CURDATE())";
        break;

    default:
        $where = "";
}

/* ================= REQUETE ================= */
$sql = "
SELECT 
    v.id_vente,
    v.date_vente,
    v.montant_total,
    v.nb_articles,
    u.nom_utilisateur
FROM ventes v
JOIN utilisateurs u ON v.id_user = u.id_user
$where
ORDER BY v.date_vente DESC
";

$ventes = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="produits-card">
    <div class="produits-title">Ventes</div>

    <!-- Boutons filtres (classes existantes) -->
    <div class="actions-cell">
        <a href="ventes.php?filtre=jour" class="btn-small btn-blue">Aujourd’hui</a>
        <a href="ventes.php?filtre=semaine" class="btn-small btn-blue">Semaine</a>
        <a href="ventes.php?filtre=mois" class="btn-small btn-blue">Mois</a>
        <a href="ventes.php?filtre=tout" class="btn-small btn-red">Tout</a>
    </div>

    <table class="ticket-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Montant total</th>
                <th>Utilisateur</th>
                <th>Nombre d'articles</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($ventes as $v): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($v['date_vente'])) ?></td>
                <td><?= number_format($v['montant_total'],2) ?> €</td>
                <td><?= $v['nom_utilisateur'] ?></td>
                <td><?= $v['nb_articles'] ?></td>
                <td>
                    <a class="btn-small btn-blue"
                       href="vente_detail.php?id=<?= $v['id_vente'] ?>">
                       détail
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>