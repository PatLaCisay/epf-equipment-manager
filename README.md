### Projet de Semestre - Manager d'equipement EPF

Projet réalisé par l'équipe composé de BARREAU Lucas (SCRUM Master), FRAPPE Arthus (PO) et CODACCIONI Kilian, GANDILLON Clément, ROYER Emile (devs).

Cette application réalisée grâce à Symfony 5.4 avec PHP 7.4 permet de visualiser le matériel disponible à l'emprunt et de gérer ses stocks.

## Installation

Cloner le projet sur votre machine :

```sh

$ git clone https://github.com/PatLaCisay/epf-equipment-manager.git

```

Créer les images Docker du système grâce à la commande :

```sh

$ docker compose up -d

```
Théoriquement, cette commande créée 4 images et un container composé de 4 sous-containers :

    - epf-equipment-manager
        - phpmyadmin_epf_manager
        - www_epf_manager
        - db_epf_manager
        - maildev_epf_manager

Ouvrir le dossier 'project', installer les dépendances et lancer le serveur Symfony :

```sh
$ docker exec -it www_epf_manager bash
$ cd project
$ composer install
$ php bin/console d:d:c #creer la bdd vide
$ php bin/console d:m:m #creer les tables dans la bdd

```
Ce message s'affiche alors après avoir consentit à la migration :

```sh
 WARNING! You are about to execute a migration in database "equipment_manager_db" that could result in schema changes and data loss. Are you sure you wish to continue? (yes/no) [yes]:
 >

[notice] Migrating up to DoctrineMigrations\Version20230330174953
[notice] finished in 1512.5ms, used 20M memory, 1 migrations executed, 17 sql queries

[OK] Successfully migrated to version : DoctrineMigrations\Version20230330174953   

```
Théoriquement, votre application est prête à tourner !