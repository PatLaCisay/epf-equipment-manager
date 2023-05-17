# Méthodologie de contribution

## Bonnes pratiques de développement

### Utilisation de la CLI Symfony
La CLI Symfony est utilisée pour générer des entités, mapper des entités, créer des fixtures, créer des utilisateurs, etc.

Pour exécuter une commande de la CLI n'oubliez pas d'executer le bash du container Docker Symfony !
```sh
$ docker exec -it www_epf_manager bash
$ php bin/console cache:clear #toujours vider le cache
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
Une fois votre issue fonctionnelle en local, ou si vous voulez qu'un tiers y ait accès publiez-la sur le repo distant :

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
