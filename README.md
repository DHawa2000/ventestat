# 📊 VenteStat - Mini plateforme de gestion et d'analyse des ventes

## 📌 Présentation du projet

VenteStat est une application web de gestion et d’analyse des ventes développée en PHP (PDO) + MySQL + Bootstrap 5.

Elle permet à une PME de gérer ses produits, enregistrer ses ventes et visualiser des indicateurs de performance (tableau de bord analytique).

---

## 🚀 Fonctionnalités

### 🔐 Authentification sécurisée
- Connexion utilisateur
- Mot de passe sécurisé avec password_hash
- Protection des pages via sessions PHP

---

### 📦 Gestion des produits (CRUD)
- Ajouter un produit
- Modifier un produit
- Supprimer un produit
- Lister les produits
- Requêtes SQL préparées (PDO)

---

### 🧾 Gestion des ventes
- Enregistrement des ventes
- Sélection de produits
- Calcul automatique du total
- Mise à jour automatique du stock
- Utilisation de transactions SQL

---

### 🔎 Recherche et pagination
- Recherche par mot-clé
- Filtrage par catégorie
- Pagination des résultats

---

### 📊 Tableau de bord analytique
- Chiffre d’affaires total (CA)
- Nombre de ventes
- Nombre de produits
- Top 5 produits vendus
- CA par produit
- CA mensuel
- Graphiques avec Chart.js (bar + line)

---

## 🧱 Technologies utilisées

- PHP (PDO)
- MySQL
- Bootstrap 5
- JavaScript (Chart.js)
- HTML5 / CSS3

---

## 🗄️ Base de données

Le fichier de base de données est inclus :

ventestat.sql

Il contient :
- Structure des tables
- Relations (clés étrangères)
- Données de test (contexte Mali : riz, sucre, huile, etc.)

---

## ⚙️ Installation

1. Cloner le projet
2. Le projet se trouve dans Laragon:
   C:\laragon\www\ventestat
3. Importer la base via phpMyAdmin :
   http://localhost/phpmyadmin
4. Lancer :
   http://localhost/ventestat

---

## 🔑 Compte de test

Username : admin  
Password : admin123  

---

## 📁 Structure du projet

ventestat/
│
├── auth/
├── config/
├── dashboard/
├── products/
├── sales/
├── includes/
├── ventestat.sql
└── index.php

---

## 👨‍💻 Auteur

Projet réalisé dans le cadre d’un examen Full Stack (PHP/MySQL)

