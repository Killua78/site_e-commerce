<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/header.php';

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Produit invalide.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Récupérer l'ID et sécuriser
$id = (int) $_GET['id'];

// Préparer la requête
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier que le produit existe
if(!$produit){
    echo "<div class='alert alert-warning'>Produit introuvable.</div>";
    require_once "includes/footer.php";
    exit;
}

?>

<h1 class="mb-4"><?= htmlspecialchars($produit['nom']) ?></h1>

<div class="row">
    <div class="col-md-6">
        <img src="assets/images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="img-fluid" style="max-height: 400px; object-fit: cover;">
    </div>
    <div class="col-md-6">
        <p><?= nl2br(htmlspecialchars($produit['description'])) ?></p>
        <p class="fw-bold fs-4"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
        <p><strong>Stock :</strong> <?= (int) $produit['stock']?> unités</p>

        <form action="panier.php" method="post" class="mt-3">
            <input type="hidden" name="id_produit" value="<?= $produit['id']?>">
            <button type="submit" class="btn btn-success">Ajouter au panier</button>
        </form>
    </div>
</div>

<!-- input type="hidden" : On cache l’ID du produit dans le formulaire, pour que quand l’utilisateur clique sur “Ajouter au panier”, on sache quel produit il veut ajouter. -->

<?php require_once 'includes/footer.php'; ?>