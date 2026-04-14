<?php 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
 ?>

<div class="topbar">

    <!-- LOGO SEUL -->
    <div class="topbar-left">
        <div class="logo">
            <img src="logo.png" alt="logo">
        </div>
    </div>

    <!-- MENU -->
    <div class="topbar-menu">
        <a href="index.php" class="menu-item">Caisse</a>
        <a href="produits.php" class="menu-item">Produits</a>
        <a href="ventes.php" class="menu-item">Ventes</a>
        <a href="lougout.php" class="menu-item">Decconexion</a>
        <a class="user">Bienvenue,<?= htmlspecialchars($_SESSION['nom']) ?></a>
    </div>

</div>