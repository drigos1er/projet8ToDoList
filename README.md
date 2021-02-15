ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

Cette application est une plateforme de gestion de tâches quotidienne .

<ol>
<li>Télécharger le projet sur : https://github.com/drigos1er/webserviceapi.git Le projet developpé sous symfony respecte l'architecture d'unn projet Symfony 4 selon l’organisation ci-dessous :
</li>
<li>Preparation de l'environnement: Installer PHP 7.3, MySQL et le serveur Apache sur votre machine ou serveur et exécuter ces différents services</li>
<li>Copier le dossier télécharger donc le dossier racine de votre environnement</li>
<li>Lancer l'installation et la mise à jour des composants grâce à composer</li>
<li>Créer les bases de donnée todolist_ db et todolisttest_ db à partir  doctrine:migrations:migrate</li>
<li>Configurer les fichier .env et .env.test dans la section DATABASE_URL entrer les configuration d’accès à votre base de données.</li>
<li>Vous pouvez accéder au blog en à partir de l’adresse : [l’adresse de votre serveur ou localhost]/[webserviceapi].</li>
</ol>

Organisation du projet

- Un dossier public contenant les fichiers images, CSS, JavaScript….

- Un dossier src contenant les codes du projet à savoir les différents Controller, les Entités, les formulaires

- Un dossier Templates contenant les Vues de notre application.

- Un dossier test contenant les unitaires et fonctionnels

- Un dossier reports permettant d'accéder au taux de couverture tests unitaires et fonctionnels

- Un dossier vendor contenant les différentes bibliothèques externes (twig…) utilisés dans notre projet.

- Un .env contenant les paramètres de connexion à la base de données et un fichier .env.test les paramètres de la connexion à la base de données test



