<?php
require_once '../includes/config.php';
// require_once '../includes/auth.php';
require_once '../includes/fonctions.php';
require_once '../includes/header.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("ID produit invalide.");
}

$id = (int) $_GET['id'];

// Récupérer le produit existant
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$produit){
    die("Produit non trouvé.");
}

$errors = [];
$success = '';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix = floatval($_POST['prix']);
    $stock = intval($_POST['stock']);

    // Gestion upload image
    if(!empty($_FILES['image']['name'])){
        $tmp = $_FILES['image']['tmp_name'];
        $original_name = basename($_FILES['image']['name']);
        $destination = '../assets/images/' . $original_name;

        if(!move_uploaded_file($tmp, $destination)){
            $errors[] = "Erreur lors de l'upload de l'image.";
        }else{
            $image = $original_name;
        }
    }else{
        // Pas d'upload, garder l'ancienne
        $image = $produit['image'];
    }

    // Validation simple
    if(empty($nom) || empty($prix)){
        $errors[] = "Le nom et le prix sont obligatoires.";
    }

    if(empty($errors)){
        // Màj en BDD
        $sql = "UPDATE products SET nom = ?, description = ?, prix = ?, image = ?, stock = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $description, $prix, $image, $stock, $id]);

        $success = "Produit modifié avec succès.";
        // Actualiser les données pour le formulaire
        $produit = [
            'nom' => $nom,
            'description' => $description,
            'prix' => $prix,
            'image' => $image,
            'stock' => $stock
        ];
    }
}
?>

<h1 class="mb-4">Modifier le produit</h1>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="w-75 mx-auto">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom :</label>
        <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($produit['nom']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description :</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($produit['description']) ?></textarea>
    </div> 

    <div class="mb-3">
        <label for="prix" class="form-label">Prix (€) :</label>
        <input type="number" name="prix" id="prix" class="form-control" step="0.01" value="<?= htmlspecialchars($produit['prix']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="stock" class="form">Stock :</label>
        <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?= htmlspecialchars($produit['stock']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Image actuelle :</label><br>
        <?php if($produit['image']): ?>
            <img src="../assets/images/<?= htmlspecialchars($produit['image']) ?>" alt="image produit" class="img-thumbnail" style="max-width: 200px">
        <?php else: ?>
            <p>Aucune image</p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Changer l'image :</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

<?php require_once '../includes/footer.php'; ?>