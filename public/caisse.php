<?php
session_start();
require_once  '../public/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* ===========================
   RECHERCHE PRODUIT
=========================== */

$recherche = "";
if (isset($_GET['recherche'])) {
    $recherche = trim($_GET['recherche']);
}

/* ===========================
   SCAN CODE-BARRES
=========================== */

$scan = "";
if (isset($_GET['scan'])) {
    $scan = trim($_GET['scan']);
}

/* ===========================
   REQUÊTE PRODUITS
=========================== */

$sql = "SELECT * FROM produits
        ORDER BY 
        (nom_produit LIKE :recherche) DESC,
        nom_produit ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':recherche' => "%$recherche%"
]);

$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Caisse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once '../public/header.php'; ?>

<div class="container">

    <!-- GAUCHE : PRODUITS -->
    <div class="left">

        <!-- BARRE DE RECHERCHE AVEC ICÔNE -->
        <form method="GET" class="search-wrapper">
            <span class="search-icon"></span>
            <input type="text" 
                   name="recherche" 
                   class="search" 
                   placeholder="Recherche produit ..." 
                   value="<?= htmlspecialchars($recherche) ?>">
        </form>


        <!-- LISTE DES PRODUITS -->
        <div class="grid">
            <?php foreach ($produits as $p): ?>
                <div class="card">

                    <div class="name"><?= htmlspecialchars($p['nom_produit']) ?></div>
                    <div class="price">Prix : <?= number_format($p['prix'], 2, ',', ' ') ?> €</div>
                    <div class="stock">Stock : <?= $p['stock'] ?></div>

                    <button class="btn-add" data-id="<?= $p['id_produit'] ?>">
                        ajouter
                    </button>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- DROITE : TICKET -->
    <div class="right">
        
      
        <h2>Ticket en cours</h2>

        <table class="ticket-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Qté</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody id="ticket-body">
                <!-- JS ajoutera les lignes ici -->
            </tbody>
        </table>

        <div class="total-box">
            Total : <span id="total">0,00 €</span>
        </div>

        <div class="actions">
            <button class="btn-cancel">Annuler / Vider</button>
            <button class="btn-validate">Valider la vente</button>
        </div>

    </div>

</div>

</body>
</html>
