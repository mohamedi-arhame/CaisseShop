<?php 
 session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajoute un produit</title>

    <!-- TON CSS GLOBAL -->
    <link rel="stylesheet" href="style.css">

    <!-- CSS de cette page uniquement -->
    <link rel="stylesheet" href="ajout-produit.css">

    <!-- DYMO -->
    <script src="https://cdn.jsdelivr.net/gh/dymosoftware/dymo-connect-framework/dymo.connect.framework.js"></script>
</head>
<body>
  <?php require_once 'header.php'; ?>
<div class="produits-card">

  <div class="produits-title">Ajoute un produit</div>

  <div class="container">

    <div class="left">
      <table class="ticket-table">
        <tr>
          <td><label>Référence :</label></td>
          <td><input id="reference"></td>
        </tr>
        <tr>
          <td><label>Nom du produit :</label></td>
          <td><input id="nomProduit"></td>
        </tr>
        <tr>
          <td><label>Prix (€) :</label></td>
          <td><input id="prix"></td>
        </tr>
        <tr>
          <td><label>Stock :</label></td>
          <td><input id="stock"></td>
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
        <button class="btn-validate" id="saveBtn">Enregistrer</button>
      </div>
    </div>

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
<script src="ajouter-produit.JS"></script>
</html>