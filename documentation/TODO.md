TODO – Projet TrouveTonRemede (Symfony + Docker + MySQL)
Date : 10 Mars 2026
SPRINT 1 – Docker + Base MySQL + Config ✓ TERMINÉ
 Ticket 1.1 – Cloner le projet oumi-blog et initialiser le nouveau repo trouve-ton-remede sur GitHub

 Ticket 1.1 – Créer la branche feature/panier et la branche de travail sprint1-ticket1-docker-launch

 Ticket 1.1 – Lancer Docker (docker-compose up -d --build) – 5 conteneurs UP : app, nginx, db, adminer, phpmyadmin

 Ticket 1.2 – Créer la branche sprint1-ticket2-create-database

 Ticket 1.2 – Créer la base MySQL trouve_ton_remede en utf8mb4

 Ticket 1.3 – Créer la branche sprint1-ticket3-env-local

 Ticket 1.3 – Générer un nouveau APP_SECRET unique pour TrouveTonRemede

 Ticket 1.3 – Créer .env.dev.local avec DATABASE_URL pointant sur trouve_ton_remede

 Ticket 1.3 – Mettre à jour APP_SECRET dans .env.dev

 Ticket 1.3 – Ajouter schema_panier.sql dans documentation/

 Ticket 1.3 – Vérifier connexion Symfony → MySQL (doctrine:schema:validate)

 Merger tous les tickets dans feature/panier et pousser sur GitHub

SPRINT 2 – Entités Doctrine + Migration ✓ TERMINÉ
 Ticket 2.1 – Créer la branche sprint2-ticket1-entity-product

 Ticket 2.1 – Créer l'entité Product (name, slug, description, price, createdAt, updatedAt)

 Ticket 2.2 – Créer la branche sprint2-ticket2-entity-cart

 Ticket 2.2 – Créer l'entité Cart (status, sessionId, createdAt, updatedAt)

 Ticket 2.3 – Créer la branche sprint2-ticket3-entity-cartitem

 Ticket 2.3 – Créer l'entité CartItem (quantity, unitPrice + relations ManyToOne Cart et Product)

 Ticket 2.4 – Créer la branche sprint2-ticket4-migration

 Ticket 2.4 – Générer la migration (make:migration)

 Ticket 2.4 – Exécuter la migration (doctrine:migrations:migrate)

 Ticket 2.4 – Créer la table product manquante (doctrine:schema:update --force)

 Ticket 2.4 – Valider le schéma (doctrine:schema:validate) → Mapping OK + Database OK

 Merger tous les tickets dans feature/panier et pousser sur GitHub

Tables créées dans trouve_ton_remede ✓
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

SPRINT 3 – Catalogue Produits ⏳ À FAIRE
 Ticket 3.1 – Créer la branche sprint3-ticket1-product-controller

 Ticket 3.1 – Créer ProductController avec routes /produits (liste) et /produits/{slug} (détail)

 Ticket 3.2 – Créer la branche sprint3-ticket2-product-list-view

 Ticket 3.2 – Créer vue templates/pages/visitor/product/list.html.twig

 Ticket 3.3 – Créer la branche sprint3-ticket3-product-show-view

 Ticket 3.3 – Créer vue templates/pages/visitor/product/show.html.twig

 Ticket 3.4 – Créer la branche sprint3-ticket4-add-to-cart-button

 Ticket 3.4 – Ajouter bouton "Ajouter au panier" sur la page détail produit

SPRINT 4 – Panier ⏳ À FAIRE
 Ticket 4.1 – Créer CartService (logique métier du panier)

 Ticket 4.2 – Créer CartController avec routes /panier, /panier/ajouter/{id}, /panier/modifier/{id}, /panier/supprimer/{id}

 Ticket 4.3 – Créer vue templates/pages/user/cart/index.html.twig

 Ticket 4.4 – Tester le flux complet (ajout, modification, suppression)

SPRINT 5 – Commandes ⏳ À FAIRE
 Ticket 5.1 – Créer entités Order et OrderItem

 Ticket 5.2 – Créer OrderController avec route /commande/valider

 Ticket 5.3 – Page "Mes commandes" dans l'espace utilisateur

SPRINT 6 – Dashboard Admin ⏳ À FAIRE
 Ticket 6.1 – CRUD produits dans l'admin

 Ticket 6.2 – Liste + détail commandes dans l'admin

Notes techniques importantes
Toujours utiliser docker-compose exec app php bin/console pour les commandes avec connexion DB

symfony console uniquement pour les commandes sans DB (make:entity)

.env.dev.local n'est jamais commité (ignoré par .gitignore)

.env.dev est commité (APP_SECRET uniquement, pas de mots de passe)

APP_SECRET TrouveTonRemede : c2a686b46f3a061514e79042309cb5d0

DATABASE_URL : mysql://root:root@db:3306/trouve_ton_remede?serverVersion=8.0&charset=utf8mb4

Ports Docker : Symfony=8000, Adminer=8080, phpMyAdmin=8081, MySQL=33066