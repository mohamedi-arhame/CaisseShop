<?php
require_once 'db.php';

$id = $_GET['id'];

if (isset($_POST['confirm'])) {

    $sql = "DELETE FROM produits WHERE id_produit = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: produits.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer produit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="container">

    <div class="produits-card" style="width:400px; margin:auto; text-align:center;">

        <div class="produits-title">Supprimer produit</div>

        <p>Tu es sûr de vouloir supprimer ce produit ?</p>

        <form method="POST">

            <button type="submit" name="confirm" class="btn-red btn-small">
                Oui supprimer
            </button>

            <a href="produits.php" class="btn-blue btn-small">
                Annuler
            </a>

        </form>

    </div>

</div>

</body>
</html>