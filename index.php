<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$recherche = "";
if (isset($_GET['recherche'])) {
    $recherche = trim($_GET['recherche']);
}

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
<?php require_once 'header.php'; ?>

<div class="container">

    <div class="left">
        <form method="GET" class="search-wrapper">
            <span class="search-icon"></span>
            <input type="text" 
                   name="recherche" 
                   class="search" 
                   placeholder="Recherche produit ..." 
                   value="<?= htmlspecialchars($recherche) ?>">
        </form>
        <p><strong>produit</strong></p>

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

    <div class="right">
        <h2>Ticket en cours</h2>

        <table class="ticket-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Qté</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="ticket-body"></tbody>
        </table>

        <div class="total-box">
            Total : <span id="total">0,00 €</span>
        </div>

        <div class="actions">
            <button class="btn-cancel">Annuler / Vider</button>
        
            <form method="POST" action="valider_vente.php">
              <button class="btn-validate">Valider</button>
             </form>
        </div>
    </div>
</div>

<script>
let panier = [];

// =========================
// AJOUTER PRODUIT
// =========================
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.btn-add').forEach(btn => {
        btn.addEventListener('click', function() {

            const id = this.dataset.id;
            const nom = this.closest('.card').querySelector('.name').textContent;
            const prixText = this.closest('.card').querySelector('.price').textContent;
            const prix = parseFloat(prixText.match(/[\d,]+/)[0].replace(',', '.'));

            const existant = panier.find(item => item.id == id);

            if (existant) {
                existant.qte++;
            } else {
                panier.push({id, nom, prix, qte: 1});
            }

            afficherPanier();
        });
    });

    document.querySelector('.btn-cancel').addEventListener('click', function() {
        panier = [];
        afficherPanier();
    });

    afficherPanier();
});

// =========================
// + AUGMENTER
// =========================
function augmenterQte(id) {
    const item = panier.find(p => p.id == id);
    if (item) {
        item.qte++;
        afficherPanier();
    }
}

// =========================
// - DIMINUER
// =========================
function diminuerQte(id) {
    const item = panier.find(p => p.id == id);
    if (item) {
        if (item.qte > 1) {
            item.qte--;
        } else {
            panier = panier.filter(p => p.id != id);
        }
        afficherPanier();
    }
}

// =========================
// AFFICHAGE PANIER
// =========================
function afficherPanier() {
    const tbody = document.getElementById('ticket-body');
    const total = document.getElementById('total');

    if (panier.length == 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="no-data">Panier vide</td></tr>';
        total.textContent = '0,00 €';
        return;
    }

    tbody.innerHTML = panier.map(item => `
        <tr>
            <td>${item.nom}</td>
            <td>${item.prix.toFixed(2).replace('.', ',')} €</td>

            <td>
              <div class="qte-box">
                <button class="btn-qte" onclick="diminuerQte(${item.id})">-</button>
                <span>${item.qte}</span>
                <button class="btn-qte" onclick="augmenterQte(${item.id})">+</button>
              </div>
            </td>
            <td>
                <button class="btn-red btn-small" onclick="panier=panier.filter(p=>p.id!=${item.id});afficherPanier();">
                    Supprimer
                </button>
            </td>
        </tr>
    `).join('');

    const somme = panier.reduce((s, item) => s + (item.prix * item.qte), 0);
    total.textContent = somme.toFixed(2).replace('.', ',') + ' €';
}

document.querySelector('.btn-validate').addEventListener('click', function(e) {
    e.preventDefault();

    if (panier.length === 0) {
        alert("Panier vide !");
        return;
    }

    fetch("valider_vente.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(panier)
    })
    .then(r => r.text())
    .then(rep => {
        if (rep.startsWith("OK")) {
            const idVente = rep.split("|")[1];
            window.location.href = "vente_detail.php?id=" + idVente;
        } else {
            alert(rep);
        }
    });
});



</script>

</body>
</html>
