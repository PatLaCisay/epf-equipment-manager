Modèle d'objets
===============

Nous avons défini différentes entités pour constituer le modèle :

 - Catégories
 - Objets
 - Salles
 - Groupes
 - Utilisateurs
 - Emprunts


Emprunts
--------
Les emprunts modélisent les emprunts des élèves, leurs réservations.

$id (int) : L'identifiant de l'objet dans la base de données.

$startDate (DateTimeImmutable) : La date de début de l'emprunt. Cette date de
fin doit nécessairement être postérieure ou égale à la date de début.

$endDate (DateTimeImmutable) : La date de fin de l'emprunt.

$description (string) : La description de l'emprunt, son utilisation.

$returnDescription (string) : La description de l'emprunt lors de son retour.

$restituted (boolean) = false : Si l'emprunt a été clôturé et les items rendus.
Faux par défaut.

$stakeholder (User): L'utilisateur responsable de l'emprunt.

$room (Room) : La salle dans laquelle les items empruntés sont utilisés.

$items (Collection d'items) : Les items empruntés.

$team (Group) : Le groupe réalisant l'emprunt.
