# Exercice - Créez un outil de gestion de contacts en ligne de commande

## Pourquoi réaliser cet exercice ?

Le but de cet exercice est de vous entraîner à la programmation orientée objet. Il permettra également d’utiliser le langage PHP d’une manière moins classique puisque vous l’utiliserez directement en ligne de commande. L’avantage ici est que vous n’aurez pas à vous soucier de problèmes d’affichage pour vous concentrer uniquement sur les nouvelles notions. 

##  Découvrez votre exercice

Dans cet exercice, vous allez créer un gestionnaire de carnet d’adresses utilisable dans un terminal en ligne de commande. Lorsque votre programme sera lancé, il devra proposer plusieurs options dans la console : 

    - Afficher la liste des contacts : list.
    - Afficher le détail d’un contact : detail.
    - Ajouter un contact : create [name], [email], [phone number].
    - Supprimer un contact : delete [id].
    - Quitter le programme : quit.
    - En bonus : vous pouvez décider d’ajouter une commande pour afficher l’aide et une autre pour modifier un contact. 

Voici un exemple de l’usage du programme lorsque vous l’aurez créé : 

```Entrez votre commande (aide, lister, détailler, créer, supprimer, quitter) : aide                                                                                                                                              

help : affiche cette aide

list : liste les contacts

create [name], [email], [phone number] : crée un contact

delete [id] : supprime un contact

quit : quitte le programme

 

Attention à la syntaxe des commandes, les espaces et virgules sont importants.

Entrez votre commande (help, list, detail, create, delete, quit) : list                                                                                                                                          

Liste des contacts :

id, name, email, phone number

3, Gandalf le gris, gandalf@istari.com, 01013021

4, Buffy Summer, buffy@sunnydale.com, 01091901

5, Hermione Granger, hermione@magie.com, 19091979

Entrez votre commande (help, list, detail, create, delete, quit) : detail 3                 

3, Gandalf le gris, gandalf@istari.com, 01013021

Entrez votre commande (help, list, detail, create, delete, quit) : quit```

Lorsque l’outil affiche les détails d’un utilisateur, c’est son id qui s’affiche en premier et qui nous servira à identifier l’utilisateur que l’on veut gérer. Ici, les utilisateurs 1 et 2 ont été supprimés, c’est pourquoi nous n’avons que 3, 4 et 5 dans la liste.

Cet exercice est entièrement guidé. Suivez pas à pas les étapes ci-dessous afin de créer le code vous-même. 

Les étapes 1 à 6 vous guideront pour mettre en place votre code et votre première commande. C’est toujours la première commande qui prend le plus de temps ! C’est donc normal de passer la majorité du projet sur la première commande, puis d’aller plus vite sur les autres. À l’étape 7, vous compléterez votre code pour y intégrer les 4 autres commandes en réutilisant ce que vous aurez appris et déjà mis en place.

## Étapes

### Étape 1 : Initialisez le projet

Le code PHP peut s’exécuter en ligne de commande (CLI : Command Line Interface). Votre première étape consiste donc à exécuter PHP en ligne de commande. 

Créez un fichier main.php et mettez ceci à l’intérieur : 

```<?php
while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";
}```

Lisons ensemble cet extrait de code : 

    - Il contient une boucle infinie. Cependant, le programme attend, avec l’instruction readline, que l’utilisateur entre quelque chose et appuie sur Entrée. 
    - Lorsque c’est fait, l’instruction echo réaffiche ce qui vient d’être saisi, le programme boucle, et le programme attend de nouveau une instruction. 

Pour lancer votre programme en ligne de commande, écrivez dans un terminal `php main.php` .

### Étape 2 : Initialisez la base de données

Maintenant que votre lecture de la ligne de commande est mise en place, installons la base de données qui nous servira à stocker nos contacts. 

> Si vous avez quelques doutes sur certains concepts liés au SQL, n’hésitez pas à retourner vérifier sur le cours Implémentez vos bases de données relationnelles avec SQL.

Voici comment mettre en place votre base de données : 

    - Créez votre base de données (MySQL ou MariaDB). 
    - Dans cette base de données, créez une table contact. Cette table contact doit contenir les champs suivants : 
        - id (int, clef primaire, auto-increment) ;
        - name (string) ;
        - email (string) ;
        - phone_number (string).
    - Insérez directement deux ou trois contacts dans votre base de données. Comme il est plus difficile de créer des données que d’en afficher, le but est d’avoir une base préremplie afin de pouvoir commencer par la commande la plus simple : list.

### Étape 3 : Créez la commande list

À ce stade, votre projet est initialisé et vous allez pouvoir créer votre première commande. Pour cela il va falloir vérifier ce que l’utilisateur a entré au clavier : 

    - Dans votre boucle infinie, ajoutez un test pour savoir si l’utilisateur a tapé “list”.
    - Si c’est le cas, affichez simplement “affichage de la liste”. 

Bravo, vous savez comment reconnaître une commande ! Maintenant, faisons en sorte que cette commande affiche (vraiment) la liste des contacts.

### Étape 4 : Créez vos première classes

Pour afficher la liste des utilisateurs, vous devez d’abord vous connecter à la base de données et créer une classe pour cela. 

> Pour y parvenir, appuyez-vous sur le cours Programmez en orienté objet en PHP aussi souvent que nécessaire ! 
 
#### Créez la classe DBConnect

Créez une classe appelée DBConnect. Le but de cette classe est de se connecter à la base de données en instanciant une connexion grâce à l’objet PDO fourni par PHP (en cas de doute, la documentation officielle peut venir à votre rescousse !).

    - Cette classe aura au minimum une méthode getPDO qui va retourner un objet PDO instancié. 
    - Pour tester, faites un var_dump de votre instance. Si vous obtenez null ou une erreur, c’est qu’il y a un souci. Ne passez pas à l’étape suivante tant qu’il n’est pas résolu !

#### Créez la classe ContactManager

Créez une classe appelée ContactManager. Le but de cette classe est d’utiliser la connexion que vous avez créée pour interroger la base de données. 

    - Dans cette classe, créez en particulier une méthode findAll() qui ne prend rien en paramètre et retourne un tableau. Chaque élément du tableau contiendra les informations d’un contact (le résultat du fetch). Le but de cette méthode sera de réaliser une requête SQL pour récupérer l’ensemble des contacts. 
    - N’oubliez pas de tester tout de suite le résultat directement dans la méthode findAll. Le but est à nouveau de s’assurer que tout fonctionne avant d’aller plus loin et d’empiler les bugs !

#### Créez la classe Contact

Créez une classe appelée Contact. Pour l’instant, un simple affichage de debug est fait depuis ContactManager, mais ce n’est pas très “propre”. Le but de la classe ContactManager est simplement de communiquer avec la base de données et de nous retourner nos contacts. 

    - Les contacts sont stockés en base de données, mais pour pouvoir les manipuler facilement, le programme a besoin de les avoir en mémoire, directement à disposition. Le but de cette classe Contact est donc de stocker en mémoire un contact qui est récupéré de la base de données. Nous créerons à l’étape suivante un tableau d’objets Contact pour garder en mémoire l’ensemble des contacts. 
    - La classe Contact contient un attribut private pour chaque champ de la base de données, et des assesseurs pour accéder à ces variables. 

Par exemple :

    - function getId() : ?int : Cette méthode va retourner l’id du contact (ou null si l’id n’est pas encore défini) ; 
    - function getName() : ?string : Cette méthode retourne le nom du contact, sous forme de chaîne de caractères, ou null si le nom n’est pas défini ;
    - function setName(?string) : void : Cette méthode permet de spécifier le nom et ne retourne rien. 

    - Ajoutez également une méthode toString() qui va s’occuper de convertir ce contact en chaîne de caractères pour pouvoir l’afficher. 

 
#### Complétez la méthode findAll du ContactManager

Modifiez la méthode findAll de votre classe ContactManager. Le but est désormais de retourner un tableau d’objets Contact, et plus directement les informations des contacts en vrac dans un tableau. 

    - À ce stade, la méthode findAll devrait retourner un tableau dans lequel chaque élément est une instance de la classe Contact (chaque instance représentant une ligne de la table contact). 
    - Comme toujours, vérifiez que votre objet n’est pas null ou empty à l’aide d’un var_dump avant de passer à la suite. 

### Étape 5 : Finalisez la commande list

Vous êtes désormais capable de récupérer l’ensemble des contacts en interrogeant la base de données. Parfait ! Allons un peu plus loin en finalisant la commande list.

    - Modifiez votre fichier main.php. Dans votre if qui teste la commande, instanciez votre classe ContactManager pour lui demander, avec findAll, la liste des contacts. 
    - Bouclez sur cette liste et utilisez votre méthode toString() pour afficher les contacts. 

Bravo, vous avez réalisé votre première commande !

### Étape 6 : Créez une classe pour gérer la logique des commandes

Actuellement, la logique des commandes se fait au même endroit que la détection des commandes. Puisque le programme va devoir supporter plusieurs commandes, le fichier main.php risque de vite devenir ingérable.

Nous allons donc créer une nouvelle classe appelée Command, qui va stocker toute la logique d’exécution de chaque commande. 

    - Créez une nouvelle classe Command dans un fichier séparé. Le but de cette classe est de contenir toutes nos commandes. 
    - Dans ce fichier, créez une méthode list() sans paramètre et qui ne retourne rien. Ce sera la première commande : c’est cette méthode qui va désormais faire appel au ContactManager pour récupérer l’ensemble des données et parcourir le tableau de Contact pour faire l’affichage. 
    - Dans main.php, lorsque vous détectez que l’utilisateur a écrit “list”, il ne vous reste plus qu’à appeler simplement la méthode list de la classe Command !

Et voilà, nous avons maintenant une classe prête à contenir toute la logique des commandes. Cela nous permet d’avoir un code de détection des commandes isolé dans le fichier main.php, et donc plus simple.

### Étape 7 : Mettez en place les commandes detail, create et delete

À ce stade nous n’avons réalisé qu’une seule commande, mais rassurez-vous, le plus dur est derrière vous ! Maintenant que le code est organisé, réaliser les commandes suivantes sera bien plus facile, car le chemin sera exactement le même ! 

#### Commande detail

Dans le fichier de commandes, écrivez la commande detail qui sert à afficher uniquement un seul contact. Pour simplifier l’exercice, les informations à afficher seront les mêmes que pour la commande list, mais pour un seul contact. 

Ici, il y a une petite difficulté. Comment détecter la commande ? Si l’utilisateur tape “detail 42” pour voir le contact numéro 42, il n’est pas possible de simplement tester si la commande vaut “detail” comme nous l’avons fait pour “list”. 

> Il y a plusieurs manières de faire, mais je vous conseille de regarder les expressions régulières et en particulier la commande preg_match. Vous pourrez en même temps vérifier que la commande commence bien par “detail” et récupérer l’id entré par l’utilisateur 🙂. 

    - Une fois que vous avez récupéré l’id, mettez à jour la classe ContactManager pour ajouter une méthode findById qui prend en paramètre l’id du contact à afficher et retourne un unique objet Contact. Attention, pas un tableau comme dans la méthode findAll, ici nous voulons juste un seul Contact.
    - Mettez également à jour la classe Command pour ajouter la commande.
    - Enfin, appelez cette nouvelle commande depuis votre boucle principale. 

#### Commande create

Sur le même modèle, créez la commande de création d’un contact. Attention à l’expression régulière, il faut que vous preniez en compte la présence des virgules afin d’isoler correctement les informations présentes dans la commande.

#### Commande delete

Sur le même modèle, créez la commande de suppression d’un contact. 

### Étape bonus : commande help

Félicitations, vous êtes arrivé au bout de cette activité. Si vous souhaitez aller un peu plus loin, vous pouvez créer une commande “help” qui affichera l’ensemble des commandes disponibles et leur description. Cette fonctionnalité est souvent indispensable lorsque l’on travaille en ligne de commande. 

De plus, il n’est pour l’instant pas possible de mettre à jour un Contact. Si vous avez bien compris les étapes précédentes, vous devriez pouvoir le faire rapidement. Dans ce cas, créez une commande modify qui modifie les informations d’un contact.

Autre bonus, pour l’instant nous avons créé une méthode toString(). 

Cependant, en PHP, il existe des méthodes dites “magiques” ; en particulier l’une d’elles, qui s’appelle  __toString et qui peut carrément changer le comportement par défaut de l’objet s’il est affiché avec un echo. Pourquoi ne pas voir s’il est possible de modifier le code avec cette méthode magique ?