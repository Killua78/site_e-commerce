<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Ma boutique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Ma Boutique</a>
        <div class="d-flex">
            <?php if(isset($_SESSION['user'])): ?>
                <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
            <?php else: ?>
                <a href="register.php" class="btn btn-outline-success me-2">Inscription</a>
                <a href="login.php" class="btn btn-outline-secondary">Connexion</a>
            <?php endif; ?>
                <a href="panier.php" class="btn btn-outline-primary me-2">Panier</a>
        </div>
    </div>
</nav>

<div class="container my-4">
