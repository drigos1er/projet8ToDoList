ToDoList: Comment contribuer au projet ?
======================================

Cette application est une plateforme de gestion de tâches quotidienne

-----------------

Les développeurs peuvent contribuer au projet en suivant la procédure ci-dessous:
* Créer ou proposer une fonctionalité (issue).
* S'assigner cette issue.
* Créer le test de cette fonctionnalité.
* Réaliser le code nécessaire au bon fonctionnement du test (Controller, entité, Formulaire, template).La mise en place des tests et fonctionalités doit respecter les bonnes pratiques Symfony (https://symfony.com/doc/4.4/best_practices.html) en général et particulier les points ci-dessous:
  * Utiliser les variables d'environnement dans le fichier env pour la configuration des infrastructures.
  * Utiliser des noms de paramètres courts et préfixés.
  * Utiliser l'Autowiring pour automatiser la configuration des services.
  * Utiliser des annotations pour définir  les entités doctrine.
  * Utiliser l'injection de dépendance pour obtenir des services.
  * Utiliser la notation Snake case pour les noms  des variables dans les vues.
  * Définissez vos formulaires grâce à des classes PHP.
  * Tester vos routes ou Url.
  * S'assurer vous que votre contrôleur étende le contrôleur de base "AbstractController".
  * Faire en sorte que votre code respecte les normes de codage PSR. Pour cela vous pouvez installer "PHP CS Fixer".
* S'assurer d'avoir un taux de couvertude d'au moins 70% de tests.
* Réaliser un audit de la qualité (un badge de qualité A serait idéal) et de la performance du code.
* Faire un pull request de cette issue.
-----------------

Par ailleurs l'on peut également contribuer à l'amélioration du code par:
* Le report,la confirmation et la correction de BUG.
* La proposition ou l'amélioration de la documentation du projet.
