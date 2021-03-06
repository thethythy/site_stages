Documentation
=============

Le site est structuré en trois parties :
- une partie public : "Présentation", "Déposer une offre de stage", "Mentions légales" ;
- une partie privée accessible par cookie d'authentification : "Stagiaire", "Enseignants référents", "Soutenances", "Téléchargement" ;
- une partie privée accessible par authentification HTTP : "Connexion".

De la documentation est accessible dans plusieurs endroits du dépôt :
- le plan du site est accessible dans classes/ihm/synoptique.png ;
- le schéma de la base de données est accessible dans classes/bdd/schema_base.png
- tous les scripts comportent (normalement) des commentaires auto-suffisants ;
- une aide en ligne (en cours !) est accessible à l'administrateur.

Développement
==============

Le répertoire classes/bdd/ contient les scripts de manipulation des tables de la base.
Chaque table est traitée par un script différent contenant une classe PHP ne comportant que des méthodes statiques.
Par exemple Etudiant_BDD.php définit les méthodes de classes d'accès à la table "etudiant".
On trouve également dans ce répertoire le fichier connec.inc gérant :
- le contrôle d'accès par cookie des pages privées ;
- la protection contre les injections SQL.

Le répertoire classes/moteur/ contient les scripts de manipulation des entités.
Chaque entité est représentée par un script différent qui délègue une partie du travail
au script associée dans classes/bdd/ ; par exemple le script Etudiant.php utilise le script Etudiant_BDD.php.

Le répertoire classes/ihm/ contient les scripts de création des flux HTML (tableaux et formulaires).
Chaque script est responsable des flux liées à un entité spécique. Par exemple,
le script Etudiant_IHM.php génère les flux liés à l'entité Etudiant.php

Le réperoire documents/ contient les fichiers déposés par les étudiants ou par
l'administrateur ainsi que les fichiers générés par le site.

Le répertoire images/ contient toutes les icônes et images.

Le reste des fichiers est organisé par bloc fonctionnel :
- le répertoire entreprise/ : dépôt des offres de stage ;
- le répertoire flux/ : le flux RSS ;
- le repertoire gestion/ : les fonctions d'administration ;
- le réperoire parrainage/ : les fonctions liées aux enseignants-référents ;
- le répertoire presentation/ : les informations public ;
- le répertoire soutenances/ : les différents plannings ;
- le répertoire stagiaire/ : les fonctions liées aux étudiants-stagiaires ;
- le répertoire telechargements/ : les documents accessibles aux étudiants.

Tout ajout ou modification dans la base de données doit entrainer la mise à
jour des fichiers et répertoires suivants :
- les scripts dans classes/bdd/ ;
- les scripts dans classes/moteur/ ;
- les scripts dans classes/ihm/ ;
- classes/bdd/schema_base.mwb --> le schéma relationnel (logiciel MySQLWorkbench) ;
- classes/bdd/schema_base.png --> l'image exportée du modèle.

Tout ajout d'une page accessible depuis le site ou directement (par diffusion
de l'URL) doit entrainer la mise à jour des fichiers et répertoires suivants :
- ajout de la page dans le répertoire concerné ;
- classes/ihm/synoptique.asta --> le modèle d'activités UML (logiciel Astah) ;
- classes/ihm/synoptique.png  --> l'image exporté du modèle.

En général, pensez à éditer si nécessaire les modèles pour qu'ils soient à jour
et cohérents par rapport aux codes existants.

Déploiement
===========

1. Créer la base de données dans une instance MySQL ainsi qu'un utilisateur
   ayant les droits de lecture / écriture (accès local ou distant selon le cas).
   Utiliser pour cela le script classes/bdd/schema_base.sql
2. Modifier le fichier classes/bdd/stages.inc pour accéder à la base MySQL.
3. Ajouter un fichier .htaccess dans le répertoire gestion/ afin de contrôler
   l'accès de cette partie par authentification HTTP (gérée par le serveur web).
4. Modifier la clef d'accès par cookie en utilisant la fonction "Gérer la clef d'accès"
5. Des fichiers sont générés :
- les exportations des statistiques dans documents/statistiques/ ;
- les exportations du schéma et des données de la base dans documents/exportations/ ;
- un journal des tentatives d'accès des parties protégées par cookie dans documents/demon/authentification.log ;
- la valeur de hachage de la clef actuelle dans documents/demon/clef ;
6. Des données sont gérées :
- un cookie d'accès est stocké sur les navigateurs des clients dès le premier accès réussi ;
- le numéro d'onglet actif de la page gestion/index.php est stocké localement dans le navigateur de l'administrateur ;
- la clef actuelle est stockée localement dans le navigateur de l'administrateur.
7. Des fichiers sont stockés :
- fichiers des offres de stages des entreprises dans documents/sujetDeStages/ ;
- fichiers des demandes de validation dans documents/sujetDeStages/ ;
- fichiers résumés de stage dans documents/resumes/ ;
- fichiers rapports de stage dans documents/rapports/
