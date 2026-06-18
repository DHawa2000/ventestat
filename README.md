# 📊 VenteStat - Mini plateforme de gestion des ventes

## 📌 Description
VenteStat est une application web développée en PHP et MySQL permettant de gérer les produits, les ventes et de visualiser des statistiques de vente.

---

## ⚙️ Technologies utilisées
- PHP (PDO)
- MySQL
- Bootstrap 5
- Chart.js

---

## 🚀 Fonctionnalités

### 🔐 Authentification
- Connexion sécurisée
- Sessions PHP
- Déconnexion

### 📦 Gestion des produits (CRUD)
- Ajouter un produit
- Modifier un produit
- Supprimer un produit
- Lister les produits

### 🧾 Gestion des ventes
- Création de vente
- Calcul automatique du total
- Mise à jour du stock
- Transaction SQL (BEGIN / COMMIT)

### 📊 Tableau de bord
- Chiffre d’affaires total
- CA par catégorie
- Top 5 produits
- CA par mois avec graphique

---

## 🔐 Sécurité
- PDO avec requêtes préparées
- Hachage des mots de passe
- Protection des pages avec sessions
- Échappement HTML (htmlspecialchars)

---

## 🗂️ Structure du projet
Le projet est organisé en modules :
- auth/
- products/
- sales/
- dashboard/
- includes/
- config/

---

## 🧪 Installation
1. Importer la base de données `database.sql`
2. Configurer `config/db.php`
3. Lancer Laragon / XAMPP
4. Accéder à : http://localhost/ventestat

---

## 👨‍💻 Auteur
Projet réalisé dans le cadre du module Full Stack & Back End.