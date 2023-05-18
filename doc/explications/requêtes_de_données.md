ItemRepository
================

La méthode `findAvailableNow()` vise à trouver les items qui sont disponibles
au moment de la demande.
Un item peut ou non avoir des réservations associées. Le critère de
disponibilité peut donc être exprimé comme étant tous les items n'ayant pas de
réservation, et ceux qui on une réservation à un autre moment que maintenant.

EN DQL, cette nouvelle condition peut s'exprimer de la façon suivante : on
sélectionne tous les items qui ne sont pas disponibles[1], puis on inverse la
sélection en ne gardant que ceux qui ne sont pas dans cette liste[2].

[1] :
```sql
SELECT i.id
FROM App\Entity\Item i
LEFT JOIN i.borrow b
WHERE b.startDate < CURRENT_DATE()
AND b.endDate > CURRENT_DATE();
```

[2] : 
```sql
SELECT it
FROM App\Entity\Item it
WHERE it.id NOT IN (
    [1]
);
```

Dans la requête [1], on utilise l'instruction `LEFT JOIN i.borrow b`. L'attribut `borrow` de `Item` est une liaison N-à-N avec la classe `Borrow`, qui correspond dans la base de données à la table `item_borrow`. Cette table est remplie automatiquement par Doctrine et n'est pas exposée en PHP ou en DQL. Pour pouvoir faire une jointure entre les items et leur réservations associées, on utilise donc l'attribut `borrow`, qui se comporte alors dans Doctrine comme la table intermédiaire, avec les liaison effectuées automatiquement.

La requête suivante en DQL :
```sql
SELECT i.id
FROM App\Entity\Item i
LEFT JOIN i.borrow b
```
est équivalente à celle-ci en SQl :
```sql
SELECT * FROM item
LEFT JOIN item_borrow ON item.id = item_borrow.item_id
LEFT JOIN borrow ON item_borrow.borrow_id = borrow.id; 
```
