Contrôleurs de logique
=========================

Les contrôleurs suivants sont disponibles :

- AvailableItems
- Borrow
- Category
- Home
- Item
- Mailer
- Registration
- Security
- UnifiedSearch
- User

AvailableItems
---------------

Ce contrôleur affiche sur la page `/available` les items disponibles au moment
de l'affichage.

Il consiste en une requête à la base de donnée pour obtenir les items
concernés par l'intermédiaire de la méthode `findAvailableNow()` de la classe
,`ItemRepository`, et fait le rendu du modèle qui lui est associé.
