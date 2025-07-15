<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/header.php';

// Initialisation du panier si vide
if(!isset($_SESSION['panier'])){
    $_SESSION['panier'] = [];
}

// Ajouter un produit au panier
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'])) {
    $id_produit = (int) $_POST['id_produit'];

    // Vérifier que le produit existe
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id_produit]);
    $produit = $stmt->fetch();

    if($produit){
        if(isset($_SESSION['panier'][$id_produit])){
            $_SESSION['panier'][$id_produit]++; // Incrémente
        }else{
            $_SESSION['panier'][$id_produit] = 1; // Ajoute
        }
        echo "<div class='alert alert-success'>Produit ajouté au panier.</div>";
    }else{
        echo "<div class'alert alert-danger'>Produit introuvable.</div>";
    }
}

// Vider le panier
if(isset($_GET['vider'])){
    $_SESSION['panier'] = [];
    echo "<div class='alert alert-warning'>Panier vidé.</div>";
}

// Afficher le panier
$panier = $_SESSION['panier'];
$total = 0;
?>

<h1 class="mb-4">Votre panier</h1>

<?php if(empty($panier)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($panier as $id => $quantite):
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $produit = $stmt->fetch();

                if($produit):
                    $sous_total = $produit['prix'] * $quantite;
                    $total += $sous_total;
            ?>
            <tr>
                <td><?= htmlspecialchars($produit['nom']) ?></td>
                <td><?= number_format($produit['prix'], 2, ',', ' ')?> €</td>
                <td><?= $quantite ?></td>
                <td><?= number_format($sous_total, 2, ',', ' ') ?> €</td>
            </tr>
            <?php
                endif;
            endforeach;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan='3' class="text-end">Total</th>
                <th><?= number_format($total, 2, ',', ' ') ?> €</th>
            </tr>
        </tfoot>
    </table>

    <a href="panier.php?vider=1" class="btn btn-danger">Vider le panier</a>
<?php endif; ?>

<?php require_once "includes/footer.php"; ?>