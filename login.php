<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/header.php';

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // vérifier que les champs sont remplis
    if(empty($email) || empty($password)){
        $errors[] = "Tous les champs sont obligatoires.";
    } 

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Adresse email invalide.";
    }

    if(empty($errors)){
        // Récupérer l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password'])){
            // Connexion OK -> stockage en session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'nom' => $user['nom']
            ];

            // Redirection vers l'accueil
            header("Location: index.php");
            exit;
        }else{
            $errors[] = "Email ou mot de passe incorrect.";
        }
    }
}

?>

<div class="container">
    <h1 class="mb-4">Connexion</h1>

    <?php if(!empty($errors)): ?>
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
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '')?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<?php require_once 'includes/footer.php' ?>