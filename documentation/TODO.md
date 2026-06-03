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

- vérifier l’affichage de l’image produit (déjà en place côté thème visitor),
- renforcer encore le bouton “Ajouter au panier” (position / comportement sur mobile),
- enrichir la zone “Bienfaits / Utilisation” à partir des nouveaux champs Product (benefits / usage).

Tests UX :
- lisibilité,
- responsive,
- cohérence avec la nouvelle home visitor.

Commit futur :
- feat(product): amélioration fiche produit (ticket 10.2).


Ticket 10.3 – Messages UX / confirmations
🚧 À faire

- Ajouter un message flash / toast visuel après ajout au panier (Bootstrap ou composant custom).
- Sur le dashboard utilisateur, ajouter un encart “Dernière commande” avec lien rapide vers /mes-commandes ou /commande/{id}.
- Sur la home, ajouter un bloc “Comment ça marche ?” (3 étapes : Choisir → Ajouter au panier → Commander).
- Vérifier cohérence des messages et traductions FR.


SPRINT 11 – Flux commandes & post-commande
🚧 En cours


Ticket 11.1 – Vider le panier après validation de la commande
✅ Terminé
(inchangé)


Ticket 11.2 – Thème visitor e‑commerce (home, blog, contact, produits, panier, commandes)
🚧 Très avancé / à finaliser

Objectif :
- harmoniser tout le front visitor et une partie user avec un thème e‑commerce plantes médicinales.

Déjà fait / très avancé :
- composant header-visitor.html.twig,
- SCSS dédié (_header_visitor.scss),
- home visitor retravaillée,
- contact visitor retravaillée,
- blog index largement harmonisé,
- produits visitor index harmonisé,
- panier et commandes largement retravaillés,
- nouveaux fichiers SCSS de pages,
- harmonisation des formulaires / boutons côté visitor.

Reste à faire pour clôturer le ticket 11.2 :
- relire les Twig/SCSS modifiés (home, blog, contact, produits, panier, orders),
- harmoniser la page blog show si nécessaire,
- lancer un tour de tests manuels :
  - home,
  - contact,
  - blog,
  - produits index/show,
  - panier (ajout, suppression),
  - commandes index/show,
- nettoyer les fichiers inutiles éventuels,
- vérifier les imports SCSS dans app.scss,
- git add de tous les fichiers concernés,
- commit : feat(visitor): thème e-commerce (ticket 11.2),
- push + PR.


Ticket 11.2 bis – Admin UI polish / pattern partagé
✅ Terminé

Objectif :
- commencer l’uniformisation visuelle admin par un pattern commun visible,
- déployer le header admin partagé sur plusieurs écrans,
- harmoniser les principaux formulaires admin sans toucher à la logique métier.

Réalisé :
- création / usage du composant partagé admin page header,
- harmonisation des pages admin suivantes :
  - category create/edit,
  - order show,
  - post create/edit/show,
  - product new/edit,
  - profile edit_profile/edit_password,
  - setting edit,
  - tag create/edit,
  - user edit_roles.

Git :
- branche : sprint11-ticket5-admin-polish
- commit : feat(admin): harmonise les pages de formulaire admin
- push : effectué
- PR : mergée


Ticket 11.3 – Intégration paiement (Stripe) & statut PAID
📝 À définir / prochain gros sujet métier

- Choisir le mode d’intégration Stripe (Checkout ou PaymentIntent).
- Ajouter les champs nécessaires sur Order (paidAt, paymentId, paymentStatus, etc.).
- Créer le contrôleur de retour / webhook Stripe qui passe la commande de PENDING à PAID.
- Adapter l’admin pour visualiser PAID vs PENDING.
- Mettre à jour les tests manuels (panier → commande PENDING → paiement → commande PAID).


SPRINT 12 – Prochaine étape probable
📝 À lancer après finalisation du visitor theme

Option prioritaire recommandée :
- Ticket 12.1 – Admin info card
  - créer components/admin/info_card.html.twig,
  - créer le SCSS associé,
  - l’appliquer à profile/edit_profile, profile/edit_password, setting/edit.

Option alternative si priorité front visitor :
- finaliser Ticket 11.2 avant d’ouvrir un nouveau chantier.


Notes techniques importantes
(inchangé, toujours valable : Docker, ports, .env, DATABASE_URL avec host db, usage de docker compose exec app php bin/console …, etc.)