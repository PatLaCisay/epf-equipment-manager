Choix techniques
=================

Cette section vide à expliquer les différents choix techniques qui ont été faits au début du projet, en particuliers les choix d'outils.

Application web
---------------

Le client du projet a fait état de son désir d'avoir une application.

Au regard de nos compétences, deux options s'offraient : créer une application native sous Android ou créer un application web.

Créer une application Android peut être complexe et nous avions peu d'expérience sur ce sujet.
En revanche, nous avions plus confiance en notre capacité à créer un application web, qui nécessite moins d'outillage spécifique.

Nous avons donc choisi de créer un application web en PHP.

PHP 8.1
--------

De par notre cursus, toute l'équipe avait un peu d'expérience avec le langage PHP. Il nous permettait de nous lancer dans un projet entreprenant mais sans avoir trop de connaissance à rattraper.

La version 8.1 de PHP n'était pas la plus récente lors du début du projet. Cependant, elle était suffisamment récente (sortie en fin 2021) pour être maintenue par le projet PHP jusqu'à fin 2024.

Symfony 5.4
-------------

Nous avons choisi d'utiliser l'environnement Symfony par-dessus PHP pour notre application. Cette décision a en partie été guidée par le fait qu'un des membres du groupe avait de l'expérience avec cet environnement.

Symfony permet de simplifier certaines parties de la gestion de l'application, par exemple une partie de la partie de sécurisation est déjà intégrée. Cet environnement permet donc d'accélérer le développement en permettant de ne pas s'attarder sur les questions qui ne sont pas liées au produit.

Nous avons utilisé la version 5.4 de Symfony car c'est une version à support allongé : elle sera maintenue jusqu'en 2024; alors que l'autre version disponible au moment du projet (la 6.2) était prévue pour arriver en fin de vie en juin 2023, soit immédiatement à la fin du projet.

Nos choix d'outils reflètent donc un volonté de stabilité de l'application et une complexité réduite pour le client, sans compromettre sur les fonctionnalités ou la sécurité.
