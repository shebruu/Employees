# Système de Gestion des Employés


<div align="center">
  
![Symfony](https://img.shields.io/badge/Symfony-7.0-000000?style=for-the-badge&logo=symfony)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

</div>

 Gestionnaire des employés : Outil RH sous Symfony 7.0 pour gérer les employés, départements, missions et analyser les statistiques de diversité.

---
## Technologies utilisées
- **Backend** : PHP 8.2+, Symfony 7.0, Doctrine ORM, Twig  
- **Frontend** : Bootstrap 5, Chart.js, Bootstrap Icons, CSS custom  
- **Base de données** : MySQL/MariaDB, Doctrine Migrations  
- **Outils** : Webpack Encore, Composer, NPM  


---
### **Prérequis**
- PHP 8.2 ou supérieur
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Serveur web (Apache/Nginx) ou PHP built-in server

### **Étapes d'installation**

#### **1. Installer les dépendances PHP**
```bash
composer install
```

#### **2. Installer les dépendances JavaScript**
```bash
npm install
```

#### **3. Configuration de l'environnement**
```bash
cp .env .env.local
# Éditer .env.local avec vos paramètres de base de données
```

#### **4. Créer la base de données**

Option A : Migrations Doctrine**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```


Option B : Import dump SQL ( récommandé) **
```bash
# Créer la base de données vide
php bin/console doctrine:database:create

# Importer le dump SQL complet (disponible dans src/)
mysql -u [username] -p [database_name] < src/employees.sql

# Synchroniser les entités avec la base existante si vous souhaitez tester les migrations
php bin/console doctrine:migrations:version --add --all
```


Option C : Schema Doctrine forcé**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:create --force
```


Option D : Réinitialisation complète**
```bash
php bin/console doctrine:database:drop --force --if-exists
php bin/console doctrine:database:create
php bin/console doctrine:schema:create --force
```


#### **5. Charger les données** *(si Option A ou C utilisée)*

**Données de test Doctrine**
```bash
php bin/console doctrine:fixtures:load
```

**Données réelles depuis dump**
```bash
# importer le dump avec données
mysql -u [username] -p [database_name] < src/employees.sql
```

#### **6. Compiler les assets**

**  développement**
```bash
npm run dev
# ou 
npm run watch
```

** production**
```bash
npm run build
```

#### **7. Démarrer le serveur**
```bash
php -S localhost:8000 -t public/
```

---

## Utilisation

### **Accès à l'application**
- **URL**: `http://localhost:8000`
- Page d'accueil avec statistiques et partenaires
- Authentification requise pour l'accès complet

### **Navigation principale**
| Module | Description | Accès |
|--------|-------------|-------|
| **Home** | Page d'accueil avec statistiques | Public |
| **Départements** | Gestion des départements | Public |
| **Employés** | CRUD des employés | Authentifié |
| **Stagiaires** | Gestion des stagiaires | Authentifié |
| **Managers** | Administration des managers | Authentifié |
| **Missions** | Gestion des missions | Authentifié |
| **Women at Work** | Statistiques de diversité | Public/Admin |

### **Rôles et permissions**
- **Visiteur** : Accès à la page d'accueil et statistiques publiques
- **Utilisateur connecté** : Accès complet aux modules de gestion
- **Administrateur** : Accès aux statistiques avancées Women at Work

---

## Structure du Projet

```
Employees/
├── src/
│   ├── Controller/          # Contrôleurs Symfony
│   ├── Entity/              # Entités Doctrine
│   ├── Form/                # Formulaires Symfony
│   └── Repository/          # Repositories Doctrine
├──  templates/
│   ├── base.html.twig       # Template de base
│   ├── home/                # Page d'accueil
│   ├── employee/            # Templates employés
│   ├── departement/         # Templates départements
│   ├── mission/             # Templates missions
│   ├── women_at_work/       # Templates statistiques
│   └── partials/            # Composants réutilisables
├── public/
│   ├── css/                 # Styles personnalisés
│   ├── images/              # Images et logos
│   └── uploads/             # Photos d'employés
├── assets/                  # Assets sources (JS/CSS)
├── config/                  # Configuration Symfony
└── migrations/              # Migrations de base de données
```

---

### 🌿 **Branches du projet**
-  `sauvegardewomenatwork` : Développement en cours


---


