TODO – Projet TrouveTonRemede
Symfony - Docker - MySQL
Date : 12 Mars 2026

SPRINT 1 – Infrastructure Docker + Base MySQL + Configuration
✅ Terminé

Ticket 1.1 – Initialisation du projet
- Cloner le projet oumi-blog
- Initialiser le nouveau dépôt trouve-ton-remede sur GitHub
- Créer la branche feature/panier
- Créer la branche sprint1-ticket1-docker-launch
- Lancer Docker : docker-compose up -d --build
- 5 conteneurs actifs : app, nginx, db, adminer, phpmyadmin

Ticket 1.2 – Base de données
- Créer la branche sprint1-ticket2-create-database
- Créer la base MySQL trouve_ton_remede en utf8mb4

Ticket 1.3 – Configuration environnement
- Créer la branche sprint1-ticket3-env-local
- Générer un nouveau APP_SECRET
- Créer .env.dev.local avec DATABASE_URL
- Mettre à jour APP_SECRET dans .env.dev
- Ajouter schema_panier.sql dans /documentation
- Vérifier la connexion Symfony → MySQL (doctrine:schema:validate)
- Merger tous les tickets dans feature/panier + push GitHub

Tables créées dans trouve_ton_remede :
user, category, tag, post, post_tag, comment, like, contact, setting, reset_password_request, product, cart, cart_item, order, order_item, doctrine_migration_versions, messenger_messages

SPRINT 2 – Entités Doctrine + Migration
✅ Terminé

Ticket 2.1 – Entité Product
- Créer branche sprint2-ticket1-entity-product
- Créer l'entité Product (name, slug, description, price, createdAt, updatedAt)

Ticket 2.2 – Entité Cart
- Créer branche sprint2-ticket2-entity-cart
- Créer l'entité Cart (status, sessionId, createdAt, updatedAt)
- Ajout relation ManyToOne → User (correction sprint 5)

Ticket 2.3 – Entité CartItem
- Créer branche sprint2-ticket3-entity-cartitem
- Créer l'entité CartItem (quantity, unitPrice)
- Relation ManyToOne → Cart
- Relation ManyToOne → Product

Ticket 2.4 – Migration
- Créer branche sprint2-ticket4-migration
- Générer la migration : make:migration
- Exécuter : doctrine:migrations:migrate
- Correction : doctrine:schema:update --force
- Validation : Mapping OK + Database OK
- Merger dans feature/panier + push GitHub

SPRINT 3 – Catalogue Produits
✅ Terminé

Ticket 3.1 – ProductController + Fixtures
- Créer branche sprint3-ticket1-product-controller
- Créer ProductController dans src/Controller/Visitor/Product/
- Route /produits → liste des produits
- Route /produits/{slug} → détail produit
- Créer ProductFixtures avec 4 produits (Camomille, Thym, Nigelle, Moringa)
- Charger les fixtures : doctrine:fixtures:load --append

Ticket 3.2 – Vue liste produits
- Créer templates/pages/visitor/product/index.html.twig
- Grille Bootstrap des produits (nom, description, prix, bouton détail)
- Correction bloc {% block main %} (au lieu de {% block body %})

Ticket 3.3 – Vue détail produit
- Créer templates/pages/visitor/product/show.html.twig
- Affichage nom, description, prix
- Breadcrumb fonctionnel
- Bouton "Ajouter au panier" activé

Merger + push GitHub ✓

SPRINT 4 – Panier
✅ Terminé

Ticket 4.1 – CartService
- Créer branche sprint4-ticket1-cart-service
- Créer src/Service/CartService.php
- Méthode getOrCreateCart() (user connecté ou session)
- Méthode addProduct()
- Méthode removeProduct()
- Méthode updateQuantity()
- Méthode getTotal()

Ticket 4.2 – CartController + Vue panier
- Créer branche sprint4-ticket2-cart-controller
- Créer src/Controller/User/Cart/CartController.php
- Route /panier → afficher le panier
- Route /panier/ajouter/{id} → ajouter un produit
- Route /panier/modifier/{id} → modifier la quantité
- Route /panier/supprimer/{id} → supprimer un article
- Créer templates/pages/user/cart/index.html.twig
- Affichage lignes panier (produit, prix unitaire, quantité, total ligne)
- Calcul du total général
- Messages flash
- Bouton "Valider la commande" activé

Ticket 4.3 – Tests fonctionnels
- Ajouter un produit au panier ✓
- Modifier la quantité ✓
- Supprimer un article ✓
- Vérifier le total ✓

Merger + push GitHub ✓

SPRINT 5 – Commandes
✅ Terminé

Ticket 5.1 – Entités commandes
- Créer branche sprint5-ticket1-entity-order
- Créer entité Order (user, subtotalHt, taxAmount, totalTtc, status, createdAt)
- Créer entité OrderItem (orderRef, product, productName, quantity, unitPriceHt, taxRate, totalHt, totalTtc)
- Relation OneToMany Order → OrderItem avec cascade: ['persist']
- Générer et exécuter la migration
- Tables order et order_item créées

Ticket 5.2 – Validation commande
- Créer branche sprint5-ticket2-order-controller
- Créer src/Service/OrderService.php
- Méthode createOrderFromCart() (calcul TVA 20%, totaux HT/TTC)
- Méthode getUserOrders()
- Créer src/Controller/User/Order/OrderController.php
- Route /commande/valider → transformer panier en commande
- Route /commande/{id} → détail commande
- Route /mes-commandes → historique commandes
- Vue templates/pages/user/order/show.html.twig
- Vue templates/pages/user/order/index.html.twig
- Tests fonctionnels : commande validée, TVA calculée, historique affiché ✓

Merger + push GitHub ✓

Fix Docker cache
- Ajout volumes dédiés app_cache et app_logs dans docker-compose.yml
- Résolution problème rmdir: Directory not empty sous Windows

SPRINT 6 – Dashboard Admin (CRUD Admin de base)
✅ Terminé

Ticket 6.1 – Gestion produits admin
- Créer branche sprint6-ticket1-admin-product
- Créer ProductController dans src/Controller/Admin/Product/
- Route /admin/produits → liste produits
- Route /admin/produits/nouveau → créer produit
- Route /admin/produits/{id}/modifier → modifier produit
- Route /admin/produits/{id}/supprimer → supprimer produit
- Restreindre accès ROLE_ADMIN
- Vues CRUD admin produits (index, new, edit, delete)
- Merger dans feature/panier + push GitHub

Ticket 6.2 – Gestion commandes admin
- Créer branche sprint6-ticket2-admin-order
- Liste toutes les commandes
- Détail d'une commande
- Modifier le statut d'une commande
- Restreindre accès ROLE_ADMIN
- Vues admin commandes (index, show, édition statut)
- Merger dans feature/panier + push GitHub

SPRINT 7 – Layouts et navigation
✅ Terminé

Ticket 7.1 – Mise à jour base_admin
- Créer branche sprint7-ticket1-update-base-admin
- Refonte du layout admin (templates/themes/base_admin.html.twig)
- Ajout du header avec navigation claire (Dashboard, Produits, Commandes, Blog…)
- Harmonisation du design (Bootstrap + SCSS _base_admin.scss)
- Merger dans feature/panier + push GitHub

Ticket 7.2 – Mise à jour base_visitor
- Créer branche sprint7-ticket2-update-base-visitor
- Mise à jour du layout visiteur (templates/themes/base_visitor.html.twig)
- Ajout du logo TrouveTonRemede et du menu : Accueil, Produits, Blog, Contact, Panier, Mes commandes, Mon compte
- Préparation du lien Panier pour futur compteur d’articles
- PR + merge dans feature/panier

Ticket 7.3 – Mise à jour base_user
- Créer branche sprint7-ticket3-update-base-user
- Mise à jour du layout utilisateur connecté (templates/themes/base_user.html.twig)
- Ajout des liens Panier et Mes commandes dans la navbar utilisateur
- Harmonisation du header avec le layout visiteur
- PR + merge dans feature/panier

SPRINT 8 – Dashboards Admin & Utilisateur
✅ Terminé

Ticket 8.1 – Dashboard admin
- Créer branche sprint8-ticket1-admin-dashboard-page
- Créer/mettre à jour src/Controller/Admin/Home/HomeController.php
- Créer/mettre à jour templates/pages/admin/home/index.html.twig
- Dashboard admin : cartes de synthèse (commandes, produits, posts, contacts…)
- Styling dédié via assets/styles/app.scss et assets/styles/themes/_base_admin.scss
- PR + merge dans feature/panier

Ticket 8.2 – Dashboard utilisateur
- Créer branche sprint8-ticket2-user-dashboard-page
- Créer/mettre à jour src/Controller/User/Home/HomeController.php
- Créer/mettre à jour templates/pages/user/home/index.html.twig
- Dashboard utilisateur : résumé commandes, liens rapides (Mes commandes, Panier, Profil…)
- Légère amélioration du header admin pour rester cohérent
- PR + merge dans feature/panier

SPRINT 9 – Page d’accueil & produits mis en avant
✅ Terminé

Ticket 9.1 – Produits mis en avant sur la home
- Créer branche sprint9-ticket1-featured-products-home
- Intégration de VichUploader pour Product (imageFile / imageName)
- Configuration vich_uploader.yaml (mapping product_image → public/images/dynamic/products)
- Configuration Nginx (client_max_body_size) + PHP (upload_max_filesize, post_max_size) pour l’upload d’images
- Mise à jour du CRUD admin produits :
  - Formulaire new/edit avec champ imageFile, affichage de l’image actuelle à l’édition
  - Liste admin avec colonne miniature
- Mise à jour WelcomeController pour charger 4 produits récents (featuredProducts)
- Mise à jour templates/pages/visitor/welcome/index.html.twig :
  - Section “Produits mis en avant” (image, nom, description courte, prix, bouton “Découvrir ce produit”
  - Bouton “Voir toutes les plantes médicinales” vers la liste produits
- PR + merge dans feature/panier

À VENIR – SPRINT 10 – Améliorations UX boutique
🚧 À planifier

Ticket 10.1 – Compteur d’articles dans le panier (navbar)
- Afficher le nombre d’articles du panier dans la navbar (layouts base_visitor, base_user)
- Utiliser CartService / repository pour récupérer le total d’items
- Adapter les templates pour afficher “Panier (X)” pour user connecté ou session
- Gérer le cas panier vide (affichage "Panier (0)" ou icône seule)

Ticket 10.2 – Amélioration fiche produit
- Sur /produits/{slug}, afficher l’image du produit (si disponible)
- Ajouter un bouton “Ajouter au panier” plus visible (couleur, taille)
- Ajouter une petite zone “Bienfaits” ou “Utilisation” (texte issu de description ou futur champ dédié)

Ticket 10.3 – Messages UX / confirmations
- Ajouter un message flash visuel après ajout au panier (ex : toast Bootstrap)
- Sur le dashboard utilisateur, ajouter un encart “Dernière commande” avec lien rapide
- Sur la home, ajouter un petit bloc “Comment ça marche ?” (3 étapes : Choisir → Ajouter au panier → Commander)

Notes techniques importantes

Commandes Symfony → toujours via Docker :
- docker-compose exec app php bin/console ...

Commandes sans DB → possible avec symfony CLI :
- symfony console make:entity

Fichiers .env :
- .env.dev.local → jamais commité (secrets)
- .env.dev → commité (APP_SECRET uniquement)

Configuration projet :
- APP_SECRET : c2a686b46f3a061514e79042309cb5d0
- DATABASE_URL : mysql://root:root@db:3306/trouve_ton_remede?serverVersion=8.0&charset=utf8mb4

Ports Docker :
- Symfony : 8000
- Adminer : 8080
- phpMyAdmin : 8081
- MySQL : 33066

✅ Sprints 1, 2, 3, 4, 5, 6, 7, 8, 9 terminés → 🚧 Sprint 10 à venir – Améliorations UX boutique
