TODO – Projet TrouveTonRemede

Symfony • Docker • MySQL

📅 Date : 10 mars 2026

🧩 SPRINT 1 – Infrastructure Docker + Base MySQL + Configuration

✅ Terminé

Ticket 1.1 – Initialisation du projet

 Cloner le projet oumi-blog

 Initialiser le nouveau dépôt trouve-ton-remede sur GitHub

 Créer la branche feature/panier

 Créer la branche de travail sprint1-ticket1-docker-launch

 Lancer Docker

docker-compose up -d --build

5 conteneurs actifs :

app

nginx

db

adminer

phpmyadmin

Ticket 1.2 – Base de données

 Créer la branche sprint1-ticket2-create-database

 Créer la base MySQL :

trouve_ton_remede

Encodage :

utf8mb4
Ticket 1.3 – Configuration environnement

 Créer la branche sprint1-ticket3-env-local

 Générer un nouveau APP_SECRET

 Créer .env.dev.local

 Configurer DATABASE_URL

 Mettre à jour APP_SECRET dans .env.dev

 Ajouter schema_panier.sql dans /documentation

 Vérifier la connexion Symfony → MySQL

docker-compose exec app php bin/console doctrine:schema:validate

 Merger tous les tickets dans feature/panier

 Push sur GitHub

🧩 SPRINT 2 – Entités Doctrine + Migration

✅ Terminé

Ticket 2.1 – Entité Product

 Créer branche sprint2-ticket1-entity-product

 Créer l'entité Product

Champs :

name

slug

description

price

createdAt

updatedAt

Ticket 2.2 – Entité Cart

 Créer branche sprint2-ticket2-entity-cart

 Créer l'entité Cart

Champs :

status

sessionId

createdAt

updatedAt

Ticket 2.3 – Entité CartItem

 Créer branche sprint2-ticket3-entity-cartitem

 Créer l'entité CartItem

Champs :

quantity

unitPrice

Relations :

ManyToOne → Cart

ManyToOne → Product

Ticket 2.4 – Migration

 Créer branche sprint2-ticket4-migration

Commandes :

docker-compose exec app php bin/console make:migration
docker-compose exec app php bin/console doctrine:migrations:migrate

Correction :

docker-compose exec app php bin/console doctrine:schema:update --force

Validation :

docker-compose exec app php bin/console doctrine:schema:validate

Résultat :

Mapping OK
Database OK

 Merge dans feature/panier

 Push GitHub

🗄 Tables créées dans la base trouve_ton_remede

user

category

tag

post

post_tag

comment

like

contact

setting

reset_password_request

product

cart

cart_item

doctrine_migration_versions

messenger_messages

🧩 SPRINT 3 – Catalogue Produits

⏳ À faire

Ticket 3.1 – ProductController

 Créer branche sprint3-ticket1-product-controller

 Créer ProductController

Routes :

/produits
/produits/{slug}

Fonctions :

liste produits

détail produit

Ticket 3.2 – Vue liste produits

 Créer branche sprint3-ticket2-product-list-view

 Créer template

templates/pages/visitor/product/list.html.twig

Contenu :

grille produits

image

nom

prix

bouton détail

Ticket 3.3 – Vue détail produit

 Créer branche sprint3-ticket3-product-show-view

 Créer template

templates/pages/visitor/product/show.html.twig

Contenu :

image

description

prix

bouton panier

Ticket 3.4 – Bouton Ajouter au panier

 Créer branche sprint3-ticket4-add-to-cart-button

 Ajouter bouton

Ajouter au panier

Sur la page détail produit

🧩 SPRINT 4 – Panier

⏳ À faire

Ticket 4.1 – CartService

 Créer CartService

Responsabilités :

ajouter produit

modifier quantité

supprimer produit

calcul total

Ticket 4.2 – CartController

 Créer CartController

Routes :

/panier
/panier/ajouter/{id}
/panier/modifier/{id}
/panier/supprimer/{id}
Ticket 4.3 – Vue panier

Créer template :

templates/pages/user/cart/index.html.twig

Contenu :

liste produits

quantité

prix

total panier

Ticket 4.4 – Tests fonctionnels

 Ajouter produit

 Modifier quantité

 Supprimer produit

 Vérifier total panier

🧩 SPRINT 5 – Commandes

⏳ À faire

Ticket 5.1 – Entités commandes

Créer :

Order

OrderItem

Ticket 5.2 – Validation commande

Créer OrderController

Route :

/commande/valider

Fonction :

transformer panier → commande

Ticket 5.3 – Espace utilisateur

Page :

Mes commandes

Fonctions :

historique commandes

détail commande

🧩 SPRINT 6 – Dashboard Admin

⏳ À faire

Ticket 6.1 – Gestion produits

CRUD produits :

créer

modifier

supprimer

lister

Ticket 6.2 – Gestion commandes

Admin :

liste commandes

détail commande

statut commande

⚙️ Notes techniques importantes
Commandes Symfony avec Docker

Toujours utiliser :

docker-compose exec app php bin/console

Exemple :

docker-compose exec app php bin/console doctrine:migrations:migrate
Commandes sans base de données

Possible avec :

symfony console

Exemple :

symfony console make:entity
Gestion des fichiers .env
.env.dev.local

❌ Jamais commité

Ignoré par .gitignore

.env.dev

✔ Committé

Contient uniquement :

APP_SECRET
🔐 Configuration projet
APP_SECRET
c2a686b46f3a061514e79042309cb5d0
DATABASE_URL
mysql://root:root@db:3306/trouve_ton_remede?serverVersion=8.0&charset=utf8mb4
🐳 Ports Docker
Service	Port
Symfony	8000
Adminer	8080
phpMyAdmin	8081
MySQL	33066

✅ Projet prêt pour Sprint 3 – Catalogue Produits