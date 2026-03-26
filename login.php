<?php
$page_title = "Connexion";
require_once 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['identifiant'] ?? '');
    $password = trim($_POST['mot_de_passe'] ?? '');

    if (login($pdo, $username, $password)) {
        header('Location: caisse.php'); // tu pourras créer cette page après
        exit;
    } else {
        $error = "Identifiant ou mot de passe incorrect.";
    }
}

require_once 'header.php';
?>

<section class="login-card">
    <h1>Connexion</h1>
    <p class="subtitle">Connectez-vous pour accéder à votre espace de gestion.</p>

    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Identifiant</label>
        <input type="text" name="identifiant" placeholder="nom.utilisateur" required>

        <label>Mot de passe</label>
        <input type="password" name="mot_de_passe" placeholder="mot de passe" required>

        <button type="submit" class="btn-green">Se connecter</button>
    </form>
</section>

</main>
</body>
</html>
