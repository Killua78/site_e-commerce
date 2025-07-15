<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/header.php';

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation simple
    if(empty($nom) || empty($email) || empty($password) || empty($confirm_password)){
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Adresse email invalide.";
    }

    if($password !== $confirm_password){
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->fetch()){
        $errors[] = "Cet email est déjà utilisé.";
    }

    if(empty($errors)){
        // Hash du mot de passe
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Insertion en BDD
        $stmt = $pdo->prepare("INSERT INTO users (email, password, nom, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$email, $hashed, $nom]);

        // Redirection vers login
        header("Location: login.php");
        exit;
    }
}

?>

<div class="container">
    <h1 class="mb-4">Inscription</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="w-50 mx-auto">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($_POST['nom'] ?? '')?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '')?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>