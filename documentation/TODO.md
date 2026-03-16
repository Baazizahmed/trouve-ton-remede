TODO – Projet TrouveTonRemede
Symfony - Docker - MySQL
Date : 16 Mars 2026

SPRINT 1 – Infrastructure Docker + Base MySQL + Configuration
✅ Terminé
(inchangé)

SPRINT 2 – Entités Doctrine + Migration
✅ Terminé
(inchangé)

SPRINT 3 – Catalogue Produits
✅ Terminé
(inchangé)

SPRINT 4 – Panier
✅ Terminé
(inchangé)

SPRINT 5 – Commandes
✅ Terminé
(inchangé)

Fix Docker cache
✅ Terminé
(inchangé)

SPRINT 6 – Dashboard Admin (CRUD Admin de base)
✅ Terminé
(inchangé)

SPRINT 7 – Layouts et navigation
✅ Terminé
(inchangé)

SPRINT 8 – Dashboards Admin & Utilisateur
✅ Terminé
(inchangé)

SPRINT 9 – Page d’accueil & produits mis en avant
✅ Terminé
(inchangé)

SPRINT 10 – Améliorations UX boutique
🚧 En cours

Ticket 10.1 – Compteur d’articles dans le panier (navbar)
✅ Terminé
(inchangé)

Ticket 10.2 – Amélioration fiche produit
🚧 À faire (à reprendre après SPRINT 11)

Sur /produits/{slug}, compléter l’UX :

vérifier l’affichage de l’image produit (déjà en place côté thème visitor),

renforcer encore le bouton “Ajouter au panier” (position / comportement sur mobile),

enrichir la zone “Bienfaits / Utilisation” à partir des nouveaux champs Product (benefits / usage).

Tests UX : lisibilité, responsive, cohérence avec la nouvelle home visitor.

Commit futur : feat(product): amélioration fiche produit (ticket 10.2).

Ticket 10.3 – Messages UX / confirmations
🚧 À faire

Ajouter un message flash / toast visuel après ajout au panier (Bootstrap ou composant custom).

Sur le dashboard utilisateur, ajouter un encart “Dernière commande” avec lien rapide vers /mes-commandes ou /commande/{id}.

Sur la home, ajouter un bloc “Comment ça marche ?” (3 étapes : Choisir → Ajouter au panier → Commander).

Vérifier cohérence des messages et traductions FR.

SPRINT 11 – Flux commandes & post-commande
🚧 Démarré

Ticket 11.1 – Vider le panier après validation de la commande
✅ Terminé
(inchangé)

Ticket 11.2 – Thème visitor e‑commerce (home, blog, contact, produits, panier, commandes)
✅ GROSSE avancée aujourd’hui (presque terminé, à relire + commit)

Objectif : harmoniser tout le front visitor et une partie user avec un thème e‑commerce plantes médicinales.

Créer/mettre à jour le header visitor :

composant header-visitor.html.twig avec badge, titre, sous‑titre, option image,

SCSS dédié (_header_visitor.scss) avec fond dégradé ou fond vert plein selon le contexte.

Home visitor :

hero e‑commerce avec image TrouveTonRemede, double CTA (voir plantes / lire les conseils),

section “Plantes médicinales populaires” avec cartes produits,

section “Qui est Oumi ?”, articles récents, contact, sur fond cohérent.

Page Contact visitor :

header visitor cohérent,

fond de section vert doux + carte blanche centrale,

formulaire aligné (labels, champs, bouton CTA, microcopy de confiance),

colonne de droite avec coordonnées + Google Maps responsive.

Blog visitor :

index : header visitor, filtres catégories/tags en dropdown, cartes article (image gauche, texte droite, tags, bouton “Lire l’article”), fond vert doux + cartes blanches,

show : à harmoniser (fond / carte) sur le même thème.

Produits visitor :

index : header visitor, fond de section vert doux, réutilisation des card-produit avec bouton btn-cta.

Panier & commandes (user / visitor) :

panier : refonte en page e‑commerce (header, tableau des items, résumé de commande en carte latérale, CTA clair),

liste commandes : carte “Historique de vos commandes” avec tableau stylé, badges de statut,

détail commande : cartes “Infos commande” + “Articles commandés” + résumé latéral, coloration du #id de commande.

SCSS :

nouveaux fichiers de page (section-contact, section-blog-index, section-products-index, section-cart, section-orders, section-order-show),

_forms.scss pour harmoniser tous les champs et boutons (btn-cta).

À faire pour clôturer le ticket 11.2 :

Relire les Twig/SCSS modifiés (home, blog, contact, produits, panier, orders).

Lancer un tour de tests manuels :

home, contact, blog, produits index/show,

panier (ajout, suppression), commandes index/show.

Nettoyer les fichiers inutiles éventuels, vérifier les imports SCSS dans app.scss.

git add de tous les fichiers (incl. nouveaux SCSS, fixtures, images, migration) puis :

commit : feat(visitor): thème e-commerce (ticket 11.2)

push + PR.

Ticket 11.3 – Intégration paiement (Stripe) & statut PAID
📝 À définir / prochain sujet

Choisir le mode d’intégration Stripe (Checkout ou PaymentIntent).

Ajouter les champs nécessaires sur Order (paidAt, paymentId, paymentStatus, etc.).

Créer le contrôleur de retour / webhook Stripe qui passe la commande de PENDING à PAID.

Adapter l’admin pour visualiser PAID vs PENDING.

Mettre à jour les tests manuels (panier → commande PENDING → paiement → commande PAID).

Notes techniques importantes
(inchangé, toujours valable : Docker, ports, .env, DATABASE_URL avec host db, usage de docker compose exec app php bin/console …, etc.)