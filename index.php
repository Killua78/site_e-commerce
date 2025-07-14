<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

// récupération des produits
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="mb-4">Nos produits</h1>
<div class="row">
    <?php foreach ($produits as $produit): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="assets/images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="card-img-top">
                <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($produit['description']))?></p>
                <p class="fw-bold"><?= number_format($produit['prix'], 2, ',', ' ' )?>€</p>
                <!-- syntaxe number_format(nombre, décimales, séparateur_decimal, séparateur_milliers) -->
                <a href="fiche_produit.php?id=<?= $produit['id']?>" class="btn btn-primary">Voir</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'includes/footer.php';