<?php 
require_once '../includes/auth.php';
require_once '../includes/config.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('Location: produits.php?erreur=id_invalide');
}

$id = (int) $_GET['id'];

// Supprimer l'image associé si présente
$req = $pdo->prepare("SELECT image FROM products WHERE id = ?");
$req->execute([$id]);
$produit = $req->fetch(PDO::FETCH_ASSOC);

if($produit && !empty($produit['image']) && file_exists('../uploads/' . $produit['image'])){
    unlink('../uploads/' . $produit['image']);
}

// Supprimer le produit de la BDD
$delete = $pdo->prepare("DELETE FROM products WHERE id = ?");
$delete->execute([$id]);

header('Location: produits.php?success=suppresion');
exit;

?>