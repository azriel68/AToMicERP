AToMicERP
=========

ERP en PHP sur une base modulaire. (Pour le moment le projet est à un stade trop peu avancé pour être exploitable, il pose juste les bases d'un nouveau noyau et d'une nouvelle ergonomie)

* Chaque fonction est un modules de /modules
* Chaque modules peut définir un js, templates et fonctions à inclure
 
Version actuelle : Alpha 2

Installation
* Allez dans /install et cliquez tour à tour sur les différents boutons d'étape (attention, dans cette alpha, aucun message n'indique la progression)
* Puis lancez manuellement le script /install/create-admin.php (les messages vous indiquerons les paramètres à ajouter)

Activation des modules
* A faire dans le fichier config.php de la racine

Modules disponibles (aucun n'est à ce stade terminé ou stable)
* core (obligatoire) contient les fonctions indispensables
* user (obligatoire) étend le module contact pour la gestion des utilisateurs
* company (obligatoire) permet de gérer les tiers et/ou entités des utilisateurs
* dictionnary (obligatoire) permet de gérer des dictionnaires de données
* conf (obligatoire) permet de gérer des global de configuration
* contact (obligatoire) permet de gérer les contacts d'une entreprise
* address, permet de gérer des adresses pour les sociétés et tout type d'objet
* Document, apporte un niveau profond de gestion de document chiffré (devis, facture, commande, etc)
* Bill, permet de gérer ses factures clients
* Project, permet de gérer des projets en AGILE
* Bank, permet de gérer vos comptes en banque et écritures
* Companion, permet l'ajout de conseil de fonctionnalité par un personnage sympathique
* currency, permet les gestion des taux de change car le logiciel est multidevise
* photo, gère l'ajout et le traitement de photo pour les produits, contact, etc
* planning, gère des actions d'utilisateur
* product, permet de gérer des produits et prix multiples
* psycho, utilise un hook pour ajouter des options de psychologie sur une fiche contact
* wallpaper, ajoute une fonctionnalité de téléchargement automatique d'un nouveau fond d'écran du logiciel




Licences
==========================
* Font : http://openfontlibrary.org/en/font/averia, http://openfontlibrary.org/en/font/pecita
* Icons : http://www.glyphish.com/
* Chart : http://www.highcharts.com/ - www.highcharts.com/license
* Avatar : gravatar.com
* Calendar : http://code.google.com/p/jquery-frontier-calendar/
* Template : http://www.tinybutstrong.com/
