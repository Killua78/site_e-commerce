<?php
require_once '../includes/config.php';
// require_once '../includes/auth.php';

// Vérifier que le user est admin
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//     header("Location: ../index.php");
//     exit;
// }

// Initialisation des variables
$nom = $description = $prix = $image = '';
$success = $error = '';

// Traitement du form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix = floatval($_POST['prix']);
    $image = null;

    // Traitement de l'image
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
        $tmp_name = $_FILES['image']['tmp_name'];
        $original_name = basename($_FILES['image']['name']);
        $destination = '../assets/images/' . $original_name;

        if(move_uploaded_file($tmp_name, $destination)){
            $image = $original_name;
        }else{
            $errors[] = "Erreur lors de l'enregistrement de l'image.";
        }
    }else{
        $errors[] = "Aucune image envoyée.";
    }

    // Validation
    if (empty($nom) || empty($description) || empty($prix) || empty($image)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Insertion en BDD
        $stmt = $pdo->prepare("INSERT INTO products (nom, description, prix, image) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nom, $description, $prix, $image])) {
            $success = "Produit ajouté avec succès.";
            $nom = $description = $prix = $image = '';
        } else {
            $error = "Erreur lors de l'ajout du produit.";
        }
    }
}

?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2>Ajouter un produit</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($nom) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€)</label>
            <input type="number" name="prix" id="prix" class="form-control" value="<?= htmlspecialchars($prix) ?>" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image du produit</label>
            <input type="file" name="image" id="image" class="form-control" value="<?= htmlspecialchars($image) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter le produit</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>