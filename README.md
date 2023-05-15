### Projet de Semestre - Manager d'equipement EPF

Projet réalisé par l'équipe composé de BARREAU Lucas (SCRUM Master), FRAPPE Arthus (PO) et CODACCIONI Kilian, GANDILLON Clément, ROYER Émile (devs).

Cette application réalisée grâce à Symfony 5.4 avec PHP 8.1 permet de visualiser le matériel disponible à l'emprunt et de gérer ses stocks.

## Installation

Clonez le projet sur votre machine :

```sh

$ git clone https://github.com/PatLaCisay/epf-equipment-manager.git

```

Créez les images Docker du système grâce à la commande :

```sh

$ docker compose up -d

```
Théoriquement, cette commande créée 4 images et un container composé de 4 sous-containers :

    - epf-equipment-manager
        - phpmyadmin_epf_manager
        - www_epf_manager
        - db_epf_manager
        - maildev_epf_manager

Ouvrez le dossier 'project', installez les dépendances et créez la base de données vide :

```sh
$ docker exec -it www_epf_manager bash #entre dans le bash de l'image Docker ('exit' pour en sortir)
$ cd project
$ composer install
$ php bin/console d:d:c #creer la bdd vide
$ php bin/console d:m:m #creer les tables dans la bdd
$ php bin/console doctrine:mapping:info

```
Vous devriez avoir affiché le mapping suivant :
```sh
 Found 6 mapped entities:

 [OK]   App\Entity\Borrow
 [OK]   App\Entity\Group
 [OK]   App\Entity\Item
 [OK]   App\Entity\Room
 [OK]   App\Entity\Category
 [OK]   App\Entity\User

```
Théoriquement, votre application tourne ici http://localhost:8741

# Méthodologie

## Bonnes pratiques de développement

### Utilisation de la CLI Symfony
La CLI Symfony est utilisée pour générer des entités, mapper des entités, créer des fixtures, créer des utilisateurs, etc.

Pour executer une commande de la CLI n'oubliez pas d'executer le bash du container Docker Symfony !
```sh
$ docker exec -it www_epf_manager bash
$ php bin/console d:m:m #toujours exécuter les migrations pour avoir la dernière structure de la BDD
```

### Remplir la Base de Données
Pour créer des données de test :
```sh
$ php bin/console d:f:l #exécute la méthode load() du fichier src\DataFixtures\AppFixtures.php
```

## Utilisation de git - gitflow

### Contexte
Vous travaillez sur l'issue 25, il s'agit d'une feature

Ouvrez un terminal à la racine du projet "your-path/equipment-manager>" et executez les commandes suivantes :

```sh

$ git checkout develop
$ git fetch

```
Assurez-vous que les modifications que vous avez en local ne rentrent pas en conflit avec celles du repo distant, sinon
réglez les conflits en concertant les personnes mises en cause dans les défauts de version ou contactez votre SM.

### Créez voter branche
```sh
$ git pull
$ git branch feat/25
$ git checkout feat/25

```

Commencez à travailler localement sur votre branche fraîchement créée. 

### Poussez votre branche sur le repo distant
Une fois votre issue fonctionnelle en local, ou si vous voulez qu'un tiers y ait accès publiez la sur le repo distant :

```sh
$ git push --set-upstream origin feat/25

```

### Créez une Pull Request (PR)
Une fois votre branche poussée, rdv sur https://github.com/PatLaCisay/epf-equipment-manager

Allez dans la section *Pull Request*, créez une PR de votre branche vers **develop**, décrivez votre travail en donnant le titre :

**"Feat #25: voici ce que j'ai fait"**

Et comme corps :

"#25 comment je l'ai fait"

Identifiez votre SM pour qu'il passe en revue votre PR. C'est tout bon !
