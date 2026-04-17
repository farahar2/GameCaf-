# GameCafé

GameCafé est une application web performante et moderne destinée à la gestion d'un café dédié aux jeux de société. 
Cette plateforme permet aux clients de réserver leurs tables et jeux préférés, tandis qu'elle offre aux administrateurs un outil complet pour gérer le catalogue de jeux, les tables, les réservations, et assurer le suivi des sessions de jeu en direct.

## 🌟 Fonctionnalités Principales

### Pour les Clients :
- **Catalogue de Jeux** : Parcourir les jeux de société disponibles par catégories, nombre de joueurs, durée ou difficulté.
- **Réservations** : Réserver une table et y associer un jeu de société pour une date et une heure précises.
- **Espace Personnel** : Gérer ses réservations et modifier son profil.

### Pour les Administrateurs :
- **Tableau de Bord** : Vue d'ensemble des statistiques de réservation, occupation des tables, etc.
- **Gestion du Catalogue** : Ajouter, modifier, ou supprimer des jeux et des catégories (CRUD complet).
- **Gestion des Tables** : Organiser les tables disponibles dans le café (`caftables`).
- **Gestion des Réservations et Sessions** : 
  - Approuver, modifier, ou annuler les réservations.
  - Démarrer, suivre et clôturer des `sessions` de jeu.

## 🛠 Technologies et Architecture

Le projet adopte une architecture **MVC (Modèle-Vue-Contrôleur)** construite en PHP Natif pour assurer une séparation claire des responsabilités, une meilleure sécurité (POO incluse), et une maintenance aisée.

* **Backend** : PHP Natif
* **Base de données** : MySQL / MariaDB
* **Architecture** : MVC (`app/Controllers`, `app/Models`, `app/views`)
* **Frontend** : HTML5, CSS3, JavaScript 

## 📂 Structure de la Base de Données

![Schéma de la base de données](<Untitled (1).png>)

Le système s'articule autour de 6 entités principales :
1. `users` : Gestion des utilisateurs (clients et administrateurs).
2. `categories` : Classification des jeux.
3. `games` : Le catalogue de jeux de société.
4. `caftables` : Les différentes tables du café.
5. `reservations` : Association entre un utilisateur, une table, éventuellement un jeu, et un créneau horaire.
6. `sessions` : Suivi en direct du moment où le jeu commence et se termine.

*Pour plus de détails, référez-vous au fichier `app/Config/database.sql`.*

## 🚀 Installation & Lancement

1. **Cloner le dépôt :**
   ```bash
   git clone [URL_DU_REPO]
   cd GameCafe
   ```

2. **Configuration de la Base de Données :**
   * Créez une nouvelle base de données locale nommée `GameCafe` (via phpMyAdmin ou en ligne de commande).
   * Importer le script SQL fourni pour créer les tables : 
     ```bash
     mysql -u votre_utilisateur -p GameCafe < app/Config/database.sql
     ```
   * Vérifiez que les paramètres de connexion de la base de données dans votre code source correspondent à votre environnement.

3. **Lancement de l'Application :**
   * Placez le répertoire du projet dans votre dossier de serveur web local (comme `htdocs` pour XAMPP ou `www` pour WAMP).
   * Accédez à l'application depuis votre navigateur : `http://localhost/GameCafé/` (Ajustez le chemin selon votre dossier de travail).

## 🔒 Sécurité
- Mots de passe chiffrés (hachage sécurisé à l'insertion).
- Protection contre les injections SQL (requêtes préparées prévues via l'implémentation des Modèles).
- Protection des routes : Vérification des rôles (Client vs Admin).