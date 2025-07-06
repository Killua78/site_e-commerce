# 🛒 Projet E-commerce - PHP / MySQL / Bootstrap

## 📑 Cahier des charges

### 🎯 Objectif
Créer un site e-commerce simple et fonctionnel permettant :
- la consultation des produits
- la gestion d’un panier
- l’inscription et la connexion d’un utilisateur
- la validation d’une commande (simulation)
- une interface d’administration pour gérer les produits

---

## 🧰 Stack technique

- **Frontend** : HTML, CSS, Bootstrap, JavaScript (léger)
- **Backend** : PHP (procédural), MySQL (via PDO)
- **BDD** : MySQL
- **Sessions** : gestion avec `$_SESSION`
- **Outils** : XAMPP, PhpMyAdmin

---

## 📦 Base de données

### Tables principales

#### `users`
- id (INT, PK)
- email (VARCHAR)
- password (VARCHAR, hashé)
- nom (VARCHAR)
- created_at (DATETIME)

#### `products`
- id (INT, PK)
- nom (VARCHAR)
- description (TEXT)
- prix (DECIMAL)
- image (VARCHAR)
- stock (INT)
- created_at (DATETIME)

#### `orders`
- id (INT, PK)
- user_id (FK)
- total (DECIMAL)
- created_at (DATETIME)

#### `order_items`
- id (INT, PK)
- order_id (FK)
- product_id (FK)
- quantity (INT)
- price (DECIMAL)

---

## ✅ Fonctionnalités

### Côté utilisateur
- Inscription / Connexion
- Liste des produits
- Fiche produit
- Panier dynamique
- Validation commande

### Côté administrateur
- Ajout / modification / suppression de produits
- Consultation des commandes

---

## 🛠️ Feuille de route

- [x] Cahier des charges
- [ ] Création base de données
- [ ] Structure des fichiers PHP
- [ ] Connexion BDD
- [ ] Accueil : affichage produits
- [ ] Fiche produit
- [ ] Panier (session)
- [ ] Authentification
- [ ] Validation commande
- [ ] Admin CRUD produits
- [ ] Sécurité & nettoyage
- [ ] Responsive + Filtres
- [ ] Déploiement

