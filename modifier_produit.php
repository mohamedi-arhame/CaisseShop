<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

/* 1. SI ON CLIQUE SUR ENREGISTRER */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "UPDATE produits SET
                reference = :reference,
                nom_produit = :nom_produit,
                prix = :prix,
                stock = :stock
            WHERE id_produit = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'reference' => $_POST['reference'],
        'nom_produit' => $_POST['nom_produit'],
        'prix' => $_POST['prix'],
        'stock' => $_POST['stock'],
        'id' => $_GET['id']
    ]);

    header("Location: produits.php");
    exit;
}

/*  2. QUAND ON ARRIVE DEPUIS LE BOUTON MODIFIER  */
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit</title>
    <link rel="stylesheet" href="style.css">
     <script src="https://cdn.jsdelivr.net/gh/dymosoftware/dymo-connect-framework/dymo.connect.framework.js"></script>
</head>
<body>
<?php require_once 'header.php'; ?>

<form method="post" action="modifier_produit.php" class="produits-title">
<div class="produits-card">

  <div class="produits-title">Modifier un produit </div>

  <div class="container">

    <div class="left">
      <table class="ticket-table">
        <tr>
          <td><label>Référence :</label></td>
          <td><input id="reference"  value="<?= $produit['reference'] ?>"></td>
        </tr>
        <tr>
          <td><label>Nom du produit :</label></td>
          <td><input id="nomProduit" value="<?= $produit['nom_produit'] ?>"></td>
        </tr>
        <tr>
          <td><label>Prix (€) :</label></td>
          <td><input id="prix" value="<?= $produit['prix'] ?>"></td>
        </tr>
        <tr>
          <td><label>Stock :</label></td>
          <td><input id="stock"  value="<?= $produit['stock'] ?>"></td>
        </tr>
        <tr>
          <td><label>Imprimante DYMO :</label></td>
          <td>
            <select id="printerSelect"></select>
          </td>
        </tr>
      </table>

      <div class="actions">
        <button class="btn-cancel">Annuler</button>
        <button class="btn-validate"  type="submit">Enregistrer</button>
      </div>
    </div>
    </form>

    <div class="right">
      <h2>Aperçu DYMO</h2>
      <div class="preview-box">
        <div id="previewZone"></div>
      </div>

      <button class="btn-validate" id="printBtn">Imprimer l’étiquette</button>
    </div>

  </div>

</div>



</body>
<script src="modifier.js"></script>
</html>