# 👥 Système de Gestion des Employés

<div align="center">

![Symfony](https://img.shields.io/badge/Symfony-7.0-000000?style=for-the-badge&logo=symfony)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

</div>

 **Application web moderne** de gestion des employés développée avec **Symfony 7.0**, permettant la gestion complète des ressources humaines, des départements, des missions et des **statistiques de diversité**.

---

## ✨ Fonctionnalités

<table>
<tr>
<td width="50%">

### 🔐 **Authentification & Autorisation**
- 🛡️ Système de connexion sécurisé
- 👑 Gestion des rôles (Admin/Utilisateur)
- 🔒 Contrôle d'accès basé sur les permissions

### 👤 **Gestion des Employés**
- ➕ CRUD des employés
- 📷 Profils détaillés 
- 📝 Gestion des informations personnelles et professionnelles
- 🏠 Interface "Mon profil" pour les utilisateurs

### 🏢 **Gestion des Départements**
- 🏗️ Administration des départements
- 👨‍💼 Attribution des managers
- 📊 Statistiques par département
- 🔗 Relations employés-départements

</td>
<td width="50%">

### 📊 **Missions & Projets**
- 🎯 Gestion des missions
- 📋 Attribution des projets aux employés
- 👨‍💻 Suivi des chefs de projet
- 📱 Interface "Mes missions" et "Mes projets"

### 👩‍💼 **Women at Work - Statistiques de Diversité**
- 📈 Répartition par genre dans les départements
- 📊 Graphiques (Chart.js)
- 🏆 Statistiques des départements les plus/moins représentés

### 🎓 **Gestion des Stagiaires**
- 👨‍🎓 Module dédié aux stagiaires
- 👥 Suivi des superviseurs
- 🎯 Interface spécialisée

</td>
</tr>
</table>

---

## 🛠️ Technologies Utilisées

<table>
<tr>
<td width="33%">

### 🖥️ **Backend**
- ![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php) **PHP 8.2+**
- ![Symfony](https://img.shields.io/badge/Symfony-7.0-000000?style=flat-square&logo=symfony) **Symfony 7.0**
- 🗃️ **Doctrine ORM**
- 🎨 **Twig**

</td>
<td width="33%">

### 🎨 **Frontend**
- ![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat-square&logo=bootstrap) **Bootstrap 5**
- 📊 **Chart.js** 
- 🎯 **Bootstrap Icons**
- 🎨 **CSS personnalisé**

</td>
<td width="33%">

### 🗃️ **Base de Données**
- ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white) **MySQL/MariaDB**
- 🔄 **Doctrine Migrations**

### ⚙️ **Outils de Développement**
- 📦 **Webpack Encore** (compilation des assets)
- 🎼 **Composer** (gestionnaire de dépendances PHP)
- 📦 **NPM** (gestionnaire de dépendances JS)

</td>
</tr>
</table>

---

## 📦 Installation

### 📋 **Prérequis**
- ✅ PHP 8.2 ou supérieur
- ✅ Composer
- ✅ Node.js & NPM
- ✅ MySQL/MariaDB
- ✅ Serveur web (Apache/Nginx) ou PHP built-in server

### 🚀 **Étapes d'installation**

#### **1. 🎼 Installer les dépendances PHP**
```bash
composer install
```

#### **2. 📦 Installer les dépendances JavaScript**
```bash
npm install
```

#### **3. ⚙️ Configuration de l'environnement**
```bash
cp .env .env.local
# Éditer .env.local avec vos paramètres de base de données
```

#### **4. 🗃️ Créer la base de données**

**🥇 Option A : Migrations Doctrine**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

**🥈 Option B : Import dump SQL ⭐ RECOMMANDÉ**
```bash
# Créer la base de données vide
php bin/console doctrine:database:create

# Importer le dump SQL complet (disponible dans src/)
mysql -u [username] -p [database_name] < src/employees.sql

# Synchroniser les entités avec la base existante si vous souhaitez tester les migrations
php bin/console doctrine:migrations:version --add --all
```

**🥉 Option C : Schema Doctrine forcé**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:create --force
```

**🔧 Option D : Réinitialisation complète**
```bash
php bin/console doctrine:database:drop --force --if-exists
php bin/console doctrine:database:create
php bin/console doctrine:schema:create --force
```

#### **5. 📊 Charger les données** *(si Option A ou C utilisée)*

**🎲 Données de test Doctrine**
```bash
php bin/console doctrine:fixtures:load
```

**📊 Données réelles depuis dump**
```bash
# importer le dump avec données
mysql -u [username] -p [database_name] < src/employees.sql
```

#### **6. 🔨 Compiler les assets**

**🔨 Mode développement**
```bash
npm run dev
# ou 
npm run watch
```

**🚀 Mode production**
```bash
npm run build
```

#### **7. 🖥️ Démarrer le serveur**
```bash
php -S localhost:8000 -t public/
```

---

## 🚀 Utilisation

### 🌐 **Accès à l'application**
- 🔗 **URL**: `http://localhost:8000`
- 🏠 Page d'accueil avec statistiques et partenaires
- 🔐 Authentification requise pour l'accès complet

### 🧭 **Navigation principale**
| Module | Description | Accès |
|--------|-------------|-------|
| 🏠 **Home** | Page d'accueil avec statistiques | Public |
| 🏢 **Départements** | Gestion des départements | Public |
| 👥 **Employés** | CRUD des employés | 🔐 Authentifié |
| 🎓 **Stagiaires** | Gestion des stagiaires | 🔐 Authentifié |
| 👨‍💼 **Managers** | Administration des managers | 🔐 Authentifié |
| 📊 **Missions** | Gestion des missions | 🔐 Authentifié |
| 👩‍💼 **Women at Work** | Statistiques de diversité | Public/Admin |

### 👑 **Rôles et permissions**
- 👀 **Visiteur** : Accès à la page d'accueil et statistiques publiques
- 👤 **Utilisateur connecté** : Accès complet aux modules de gestion
- 👑 **Administrateur** : Accès aux statistiques avancées Women at Work

---

## 📁 Structure du Projet

```
🏗️ Employees/
├── 📂 src/
│   ├── 🎮 Controller/          # Contrôleurs Symfony
│   ├── 🏗️ Entity/              # Entités Doctrine
│   ├── 📝 Form/                # Formulaires Symfony
│   └── 🗃️ Repository/          # Repositories Doctrine
├── 🎨 templates/
│   ├── 📄 base.html.twig       # Template de base
│   ├── 🏠 home/                # Page d'accueil
│   ├── 👥 employee/            # Templates employés
│   ├── 🏢 departement/         # Templates départements
│   ├── 📊 mission/             # Templates missions
│   ├── 👩‍💼 women_at_work/       # Templates statistiques
│   └── 🧩 partials/            # Composants réutilisables
├── 🌐 public/
│   ├── 🎨 css/                 # Styles personnalisés
│   ├── 🖼️ images/              # Images et logos
│   └── 📁 uploads/             # Photos d'employés
├── ⚡ assets/                  # Assets sources (JS/CSS)
├── ⚙️ config/                  # Configuration Symfony
└── 🔄 migrations/              # Migrations de base de données
```

---

### 🌿 **Branches du projet**
- 🔄 `sauvegardewomenatwork` : Développement en cours
- 📚 Autres branches de fonctionnalités archivées

---

## 👥 Contributeurs

Projet développé dans le cadre d'un système de gestion des ressources humaines avec focus sur la diversité et l'inclusion.

## 📄 Licence

Propriétaire - Tous droits réservés

---

> 💡 **Note** : Ce projet est en développement actif. Pour toute question ou contribution, veuillez créer une issue dans le repository.