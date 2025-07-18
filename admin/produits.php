<?php
// require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/fonctions.php';
require_once '../includes/header.php';

// Récupérer tous les produits
try{
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}
?>

<h1 class="mb-4">Gestion des produits</h1>

<a href="ajouter_produit.php" class="btn btn-success mb-3">➕ Ajouter un produit</a>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Titre</th>
            <th>Prix (€)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($produits) > 0): ?>
            <?php foreach($produits as $produit): ?>
                <tr>
                    <td><?= $produit['id'] ?></td>
                    <td>
                        <?php if(!empty($produit['image'])): ?>
                            <img src="../assets/images/<?= htmlspecialchars($produit['image']) ?>" alt="Produit" width="60">
                        <?php else: ?>
                            <span>Aucune</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($produit['nom']) ?></td>
                    <td><?= number_format($produit['prix'], 2, ',', ' ')?></td>
                    <td>
                        <a href="modifier_produit.php?id=<?= $produit['id']?>" class="btn btn-sm btn-primary">✏️ Modifier</a>
                        <a href="supprimer_produit.php?id=<?= $produit['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression de ce produit ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">Aucun produit trouvé.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>