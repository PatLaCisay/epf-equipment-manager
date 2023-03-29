# Projet de Semestre – Gestionnaire d'équipements EPF

Projet réalisé par l'équipe composée de BARREAU Lucas (SCRUM Master), FRAPPE Arthus (PO) et CODACCIONI Kilian, GANDILLON Clément, ROYER Émile (devs).

Cette application réalisée grâce à Symfony 5.4 avec PHP 7.4 permet de visualiser le matériel disponible à l'emprunt et de gérer ses stocks.

## Installation

Cloner le projet sur votre machine :

```sh

$ git clone https://github.com/PatLaCisay/epf-equipment-manager.git

```

Créer les images Docker du système grâce à la commande :

```sh

$ docker compose up -d

```
Théoriquement, cette commande crée 4 images et un conteneur composé de 4 sous-conteneurs :

    - epf-equipment-manager
        - phpmyadmin_epf_manager
        - www_epf_manager
        - db_epf_manager
        - maildev_epf_manager

Pour lancer l'application, ouvrir le dossier 'project', installer les dépendances
et lancer le serveur Symfony :

```sh
$ cd project
$ composer install # Installation des dépendances
$ symfony server:start
```
