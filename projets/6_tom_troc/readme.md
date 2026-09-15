## Site TomTroc

Ce projet a été réalisé dans le cadre de la formation "Développeur d'application PHP Symfony"

Le projet est contenu dans un monorepo dédié à la formation. Tous les commits liés sont sur la branche "6_site_tom_troc" de ce dépôt.

## Pour utiliser ce projet : 

- Commencez par cloner le projet 06. La commande git sparse-checkout permet d'extraire uniquement le projet06B.
```
git clone --no-checkout -b 6_site_tom_troc https://github.com/MAT044/monorepo-formation-openclassrooms.git 06_Tom_Troc_Vincent_Dorian
cd 06_Tom_Troc_Vincent_Dorian
git sparse-checkout init --cone
git sparse-checkout set projets/6_tom_troc
git checkout
```
- Le projet peut s'exécuter avec le serveur PhP built-in (à exécuter dans la dossier "public" du projet06). Celui-ci est contenu dans le sous-dossier "projets/6_tom_troc" du monorepo.
```
cd projets/6_tom_troc/public
php -S localhost:8000 index.php
```


## Lancez le projet ! 

- Créez le fichier db.ini pour renseigner les informations de connexion à votre DB.
- Créer une base de données vides (Nom configurable dans le fichier db.ini)
NB : un fichier docker-compose.yml fournit une base de test prête à l'emploi. le fichier db.example.ini donne en example les informations à saisir pour fonctionner avec cette base de doonées
- Importez le fichier _v1_database.sql_ dans votre base de données.
- [Optionnel] Importez le fichier _v1_fixtures.sql_ dans votre base de données.

Tous les utilisateurs des fixtures ont pour mot de passe "test"

## Problèmes courants :

Il est possible que la librairie intl ne soit pas activée sur votre serveur par défaut. Cette librairie sert notamment à traduire les dates en francais. Dans ce cas, vous pouvez soit utiliser l'interface de votre serveur local pour activer l'extention (wamp), soit aller modifier directement le fichier _php.ini_. 

Ce projet a été réalisé avec PHP 8.3. Bien que d'autres versions de PHP puissent fonctionner, il n'est pas garanti que le projet fonctionne avec des versions antérieures.

## Copyright : 

Projet utilisé dans le cadre d'une formation Openclassrooms. 