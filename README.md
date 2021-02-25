# ToDoList
## _Base du projet #8 : Améliorez un projet existant_

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/84ec28a0fea44b398acfcc75a9209796)](https://app.codacy.com/gh/drigos1er/projet8ToDoList?utm_source=github.com&utm_medium=referral&utm_content=drigos1er/projet8ToDoList&utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/84ec28a0fea44b398acfcc75a9209796)](https://app.codacy.com/gh/drigos1er/projet8ToDoList?utm_source=github.com&utm_medium=referral&utm_content=drigos1er/projet8ToDoList&utm_campaign=Badge_Grade_Settings)

Cette application est une plateforme de gestion de tâches quotidienne,
https://openclassrooms.com/projects/ameliorer-un-projet-existant-1
Developpée avec le frameworrk PHP Symfony 4


## Fonctionnalités

- Création, modification, suppression d'utilisateur.
- Création, modification, suppression de tâches.

## Installation

Télécharger le projet sur : https://github.com/drigos1er/projet8ToDoList.git.

Installer PHP 7.3, MySQL 5.7 et Apache 2 sur votre machine ou serveur.

Exécuter tous ces services.

Copier le projet téléchargé dans le répertoire racine de votre environnement.

Lancer l'installation et la mise à jour des composants grâce à composer.

```sh
composer update
```

Créer les bases de donnée à partir des migrations.

```sh
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
Charger les données de bases à partir des fictures.
```sh
php bin/console doctrine:fixtures:load
```

Entrer les configuration d’accès à vos bases de données dans la section DATABASE_URL des fichiers .env et .env.test.

```sh
DATABASE_URL=
```
Vous pouvez accéder au projet à partir de l’adresse : [l’adresse de votre serveur ou localhost]/[projet8ToDoList]/public/.
```sh
[l’adresse de votre serveur ou localhost]/[nomprojet]/public/.

Default user login:todoadm paswword:UsrTD2@21
```

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/ca4c5bb06eb94a238fec8c5f0e0b0c97)](https://www.codacy.com/gh/drigos1er/projet8ToDoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=drigos1er/projet8ToDoList&amp;utm_campaign=Badge_Grade)
