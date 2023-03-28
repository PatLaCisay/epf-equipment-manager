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

Ouvrir le dossier 'project' et lancer le serveur Symfony :

```sh

$ cd project

$ symfony server:start

```
