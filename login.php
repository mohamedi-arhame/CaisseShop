<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="logo-connect">
    <img src="logo.png" alt="Logo">
</div>

<div class="page">
    <div class="card">

        <h1>Connexion</h1>

        <p class="desc">
            Connectez-vous pour accéder à votre espace<br>
            de gestion.
        </p>

        <form action="../CaisseShop/traitte-logine.php" method="POST">
            <label>Identifiant</label>
            <input type="text" name="email" placeholder="nom.utilisateur">

            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••">

            <button type="submit">
                Se connecter <span>›</span>
            </button>
        </form>

    </div>
</div>

</body>
</html>