TODO – Projet TrouveTonRemede
Symfony - Docker - MySQL
Date : 12 Mars 2026
SPRINT 1 – Infrastructure Docker + Base MySQL + Configuration
✅ Terminé
Ticket 1.1 – Initialisation du projet

 Cloner le projet oumi-blog

 Initialiser le nouveau dépôt trouve-ton-remede sur GitHub

 Créer la branche feature/panier

 Créer la branche sprint1-ticket1-docker-launch

 Lancer Docker : docker-compose up -d --build

 5 conteneurs actifs : app, nginx, db, adminer, phpmyadmin

Ticket 1.2 – Base de données

 Créer la branche sprint1-ticket2-create-database

 Créer la base MySQL trouve_ton_remede en utf8mb4

Ticket 1.3 – Configuration environnement

 Créer la branche sprint1-ticket3-env-local

 Générer un nouveau APP_SECRET

 Créer .env.dev.local avec DATABASE_URL

 Mettre à jour APP_SECRET dans .env.dev

 Ajouter schema_panier.sql dans /documentation

 Vérifier la connexion Symfony → MySQL (doctrine:schema:validate)

 Merger tous les tickets dans feature/panier + push GitHub

SPRINT 2 – Entités Doctrine + Migration
✅ Terminé
Ticket 2.1 – Entité Product

 Créer branche sprint2-ticket1-entity-product

 Créer l'entité Product (name, slug, description, price, createdAt, updatedAt)

Ticket 2.2 – Entité Cart

 Créer branche sprint2-ticket2-entity-cart

 Créer l'entité Cart (status, sessionId, createdAt, updatedAt)

 Ajout relation ManyToOne → User (correction sprint 5)

Ticket 2.3 – Entité CartItem

 Créer branche sprint2-ticket3-entity-cartitem

 Créer l'entité CartItem (quantity, unitPrice)

 Relation ManyToOne → Cart

 Relation ManyToOne → Product

Ticket 2.4 – Migration

 Créer branche sprint2-ticket4-migration

 Générer la migration : make:migration

 Exécuter : doctrine:migrations:migrate

 Correction : doctrine:schema:update --force

 Validation : Mapping OK + Database OK

 Merger dans feature/panier + push GitHub

Tables créées dans trouve_ton_remede :
user, category, tag, post, post_tag, comment, like, contact, setting, reset_password_request, product, cart, cart_item, order, order_item, doctrine_migration_versions, messenger_messages

SPRINT 3 – Catalogue Produits
✅ Terminé
Ticket 3.1 – ProductController + Fixtures

 Créer branche sprint3-ticket1-product-controller

 Créer ProductController dans src/Controller/Visitor/Product/

 Route /produits → liste des produits

 Route /produits/{slug} → détail produit

 Créer ProductFixtures avec 4 produits (Camomille, Thym, Nigelle, Moringa)

 Charger les fixtures : doctrine:fixtures:load --append

Ticket 3.2 – Vue liste produits

 Créer templates/pages/visitor/product/index.html.twig

 Grille Bootstrap des produits (nom, description, prix, bouton détail)

 Correction bloc {% block main %} (au lieu de {% block body %})

Ticket 3.3 – Vue détail produit

 Créer templates/pages/visitor/product/show.html.twig

 Affichage nom, description, prix

 Breadcrumb fonctionnel

 Bouton "Ajouter au panier" activé

Merger + push GitHub ✓

SPRINT 4 – Panier
✅ Terminé
Ticket 4.1 – CartService

 Créer branche sprint4-ticket1-cart-service

 Créer src/Service/CartService.php

 Méthode getOrCreateCart() (user connecté ou session)

 Méthode addProduct()

 Méthode removeProduct()

 Méthode updateQuantity()

 Méthode getTotal()

Ticket 4.2 – CartController + Vue panier

 Créer branche sprint4-ticket2-cart-controller

 Créer src/Controller/User/Cart/CartController.php

 Route /panier → afficher le panier

 Route /panier/ajouter/{id} → ajouter un produit

 Route /panier/modifier/{id} → modifier la quantité

 Route /panier/supprimer/{id} → supprimer un article

 Créer templates/pages/user/cart/index.html.twig

 Affichage lignes panier (produit, prix unitaire, quantité, total ligne)

 Calcul du total général

 Messages flash

 Bouton "Valider la commande" activé

Ticket 4.3 – Tests fonctionnels

 Ajouter un produit au panier ✓

 Modifier la quantité ✓

 Supprimer un article ✓

 Vérifier le total ✓

Merger + push GitHub ✓

SPRINT 5 – Commandes
✅ Terminé
Ticket 5.1 – Entités commandes

 Créer branche sprint5-ticket1-entity-order

 Créer entité Order (user, subtotalHt, taxAmount, totalTtc, status, createdAt)

 Créer entité OrderItem (orderRef, product, productName, quantity, unitPriceHt, taxRate, totalHt, totalTtc)

 Relation OneToMany Order → OrderItem avec cascade: ['persist']

 Générer et exécuter la migration

 Tables order et order_item créées

Ticket 5.2 – Validation commande

 Créer branche sprint5-ticket2-order-controller

 Créer src/Service/OrderService.php

 Méthode createOrderFromCart() (calcul TVA 20%, totaux HT/TTC)

 Méthode getUserOrders()

 Créer src/Controller/User/Order/OrderController.php

 Route /commande/valider → transformer panier en commande

 Route /commande/{id} → détail commande

 Route /mes-commandes → historique commandes

 Vue templates/pages/user/order/show.html.twig

 Vue templates/pages/user/order/index.html.twig

 Tests fonctionnels : commande validée, TVA calculée, historique affiché ✓

Merger + push GitHub ✓

Fix Docker cache

 Ajout volumes dédiés app_cache et app_logs dans docker-compose.yml

 Résolution problème rmdir: Directory not empty sous Windows

SPRINT 6 – Dashboard Admin
🚧 En cours
Ticket 6.1 – Gestion produits admin

 Créer branche sprint6-ticket1-admin-product

 Créer ProductController dans src/Controller/Admin/Product/

 Route /admin/produits → liste produits

 Route /admin/produits/nouveau → créer produit

 Route /admin/produits/{id}/modifier → modifier produit

 Route /admin/produits/{id}/supprimer → supprimer produit

 Restreindre accès ROLE_ADMIN

 Vues CRUD admin produits

Ticket 6.2 – Gestion commandes admin

 Créer branche sprint6-ticket2-admin-order

 Liste toutes les commandes

 Détail d'une commande

 Modifier le statut d'une commande

Notes techniques importantes
Commandes Symfony → toujours via Docker :

bash
docker-compose exec app php bin/console mmande>
Commandes sans DB → possible avec symfony CLI :

bash
symfony console make:entity
Fichiers .env :

.env.dev.local → jamais commité (secrets)

.env.dev → commité (APP_SECRET uniquement)

Configuration projet :

APP_SECRET : c2a686b46f3a061514e79042309cb5d0

DATABASE_URL : mysql://root:root@db:3306/trouve_ton_remede?serverVersion=8.0&charset=utf8mb4

Ports Docker :

Service	Port
Symfony	8000
Adminer	8080
phpMyAdmin	8081
MySQL	33066
✅ Sprint 1, 2, 3, 4, 5 terminés → 🚧 Sprint 6 en cours – Dashboard Admin