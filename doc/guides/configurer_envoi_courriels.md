Configurer l'envoi de courriels
=================================

L'application doit être configurée pour envoyer des courriels.

L'envoi des courriels utilise le protocole [SMTP](https://fr.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol), comme beaucoup de clients de courriel.

Les paramètres de connexion SMTP sont indiqués dans la variable d'environnement
`MAILER_DSN`.

Comme il est nécessaire d'indiquer le mot de passe du compte, il ne faut pas
partager cette configuration et la garder en local. Le fichier `.env.local` est
adapté à cet usage.

Voici un exemple de configuration, en utilisant les [paramètres pour un serveur
Office365](https://support.microsoft.com/fr-fr/office/param%C3%A8tres-pop-imap-et-smtp-8361e398-8af4-4e97-b147-6c6c4ac95353).
```sh
EMAIL_ADDRESS="adresse@example.org"
MAILER_DSN=smtp://${EMAIL_ADDRESS}:"###"@smtp.office365.com:587
```

La variable *MAILER_DSN* a la syntaxe suivante : `smtp://adresse:motdepasse@serveur:port`.

Une fois le protocole configuré, des courriels peuvent être envoyés.

Il est possible de configurer le client pour que les courriels ne soient pas
envoyés directement, mais attendent de façon asynchrone dans une file d'attente.

Pour les envoyer au serveur, il est alors nécessaire d'utiliser un
*travailleur*, qui va consommer les messages en attente.

En invoquer un simplement avec la ligne de commande se fait comme suit:
```sh
php bin/console messenger:consume async
```

Le travailleur enverra les messages en attente et ceux qui seront envoyés
pendant son exécution.
Le travailleur continuera à tourner en mode *démon* tant qu'il n'est pas arrêté.

Il est possible d'automatiser le démarrage des travailleurs avec divers outils,
 comme la documentation de Symfony l'indique sur [cette
 page](https://symfony.com/doc/5.4/messenger.html#deploying-to-production).
