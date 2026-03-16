
TODO – Projet TrouveTonRemede
Symfony - Docker - MySQL
Date : 16 Mars 2026

SPRINT 1 – Infrastructure Docker + Base MySQL + Configuration
✅ Terminé

(inchangé, juste conservé)

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

Créer branche sprint10-ticket1-cart-counter

Utiliser CartService / repository pour récupérer le total d’items du panier courant (user connecté ou session).
​

Exposer ce total à la vue (par ex. via un Twig global / EventSubscriber / contrôleur de base).

Adapter les layouts base_visitor et base_user pour afficher “Panier (X)” dans la navbar.

Gérer le cas panier vide (affichage “Panier (0)” ou icône seule).

Tests manuels :

panier vide → affichage correct,

ajout d’un produit → compteur mis à jour,

modification / suppression → compteur mis à jour.

Commit, push et PR mergée dans feature/panier.

Ticket 10.2 – Amélioration fiche produit
🚧 À faire

Sur /produits/{slug}, afficher l’image du produit (si disponible).

Mettre en avant le bouton “Ajouter au panier” (taille, couleur, position).

Ajouter une petite zone “Bienfaits / Utilisation” (texte basé sur la description ou futur champ dédié).

Tests UX : lisibilité, responsive, cohérence avec la home.

Ticket 10.3 – Messages UX / confirmations
🚧 À faire

Ajouter un message flash visuel après ajout au panier (toast Bootstrap, alerte, etc.).

Sur le dashboard utilisateur, ajouter un encart “Dernière commande” avec lien rapide vers /mes-commandes ou /commande/{id}.

Sur la home, ajouter un bloc “Comment ça marche ?” (3 étapes : Choisir → Ajouter au panier → Commander).

Vérifier la cohérence des messages et traductions.

SPRINT 11 – Flux commandes & post-commande
🚧 Démarré

Ticket 11.1 – Vider le panier après validation de la commande
✅ Terminé

Créer branche sprint11-ticket1-clear-cart-after-order.

Mettre à jour CartService :

ajouter clearCart(Cart $cart) qui supprime tous les CartItem du panier,

vider la collection cartItems côté objet,

passer le Cart au statut ORDERED,

mettre à jour updatedAt,

flush() global.

Mettre à jour OrderController (user) :

dans /commande/valider, après createOrderFromCart(), appeler $this->cartService->clearCart($cart),

conserver la redirection vers la page détail de commande.

Vérifier que les commandes sont créées en statut PENDING (logique de future intégration paiement).
​

Tests manuels :

valider une commande → la nouvelle commande apparaît dans “Mes commandes”,

le panier est vide après validation,

le badge du panier revient à 0 / n’apparaît plus,

en base, le Cart associé à la commande est bien en ORDERED et les CartItem supprimés.

Commit : feat(order): vider le panier après validation (ticket 11.1)

Push et PR créée sur GitHub (sprint11-ticket1-clear-cart-after-order).

Ticket 11.2 – Intégration paiement (Stripe) & statut PAID
📝 À définir / prochain sujet

Choisir le mode d’intégration Stripe (Checkout ou Payment Intent).
​

Ajouter les champs nécessaires sur Order (ex : paidAt, paymentId / paymentMethod, éventuellement paymentStatus).

Créer le contrôleur de retour / webhook Stripe qui passera la commande de PENDING à PAID en cas de succès.
​

Adapter l’admin pour visualiser clairement les commandes PAID vs PENDING.

Mettre à jour les tests manuels (scénario complet : panier → commande PENDING → paiement → commande PAID).

Notes techniques importantes
(inchangé, toujours valable pour le projet : Docker, ports, .env, commandes console, etc.)