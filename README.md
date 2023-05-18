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

## Contribution

Afin d'assurer que votre contribution soit en phase avec la méthodologie directrice de ce projet, consultez la page suivante: [Méthodologie de contribution](CONTRIBUTING.md)