<?php 
require_once 'boutd_code.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once 'header.php'; ?>

<div class="container">

    <div class="left" style="width:100%">

        <!-- (recherche + bouton) -->
        <div class="produits-header">

            <!-- RECHERCHE -->
            <form method="GET" class="search-wrapper">
                
                <input type="text" 
                       name="recherche" 
                       class="search" 
                       placeholder="Recherche produit ..." 
                       value="<?= htmlspecialchars($recherche) ?>">

                <button type="submit" class="btn-search">
                    Rechercher
                </button>

            </form>

            <!-- AJOUT PRODUIT -->
            <a href="ajouter_produit.php" class=" produit-ajouté produit-ajouté:hover ">
                + Ajouter un produit
            </a>

        </div>

        <!-- CARD PRODUITS -->
        <div class="produits-card">

            <!-- TITRE -->
            <div class="produits-title">
                Liste des produits
            </div>

            <!-- TABLE -->
            <table class="ticket-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Nom du produit</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($produits) > 0): ?>
                        
                        <?php foreach ($produits as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['reference']) ?></td>
                                <td><?= htmlspecialchars($p['nom_produit']) ?></td>
                                <td><?= number_format($p['prix'], 2, ',', ' ') ?> €</td>
                                <td><?= $p['stock'] ?></td>

                                <td style="display:flex; gap:5px;">

                                    <!-- MODIFIER -->
                                    <a
                                     href="modifier_produit.php?id=<?= $p['id_produit'] ?>" 
                                       class="btn-small btn-blue">
                                        Modifier
                                    </a>

                                    <!-- SUPPRIMER -->
                                    <a href="supprimer_produit.php?id=<?= $p['id_produit'] ?>" 
                                       class="btn-small btn-red">
                                        Supprimer
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5" style="text-align:center; padding:15px;">
                                Aucun produit trouvé
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>