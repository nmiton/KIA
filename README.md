<h1 align="center">Projet Keep It Alive</h1>

<p align="center">Projet réalisé lors de la formation POEC Symfony au sein de l'organisation ALIPTIC (https://www.aliptic.net).</p><br>

<p align="center"><img src="public/assets/img/logo.png" align="center" alt="Logo keep it alive"></p><br><br>

<h1 align="center">INSTALATION</h1>
<p>Ce projet Symfony et en version 5.4. </p>

AVANT TOUT IL VOUS FAUDRA AU PRÉALABLE INSTALLER "Composer" : https://getcomposer.org/download/ <br>
ET UN SYSTEME DE BDD EN LOCAL VOUS POUVEZ UTILISER SQLITE OU MYSQL AVEC : https://www.wampserver.com/

Il vous faudra dans un premier tant dans un dossier faire cette commande:<br>
<code>git clone https://github.com/nmiton/kia.git</code>

Ensuite dans le dossier créé "kia" il vous faudra entrer cette commande:<br>
<code>composer update</code>
*Par précaution faite la commande 2 fois, il peut ne pas avoir mit toutes les versions en 5.4.

<h1 align="center">UTILISATION</h1>

<p>Dans le fichier .ENV à la racine de votre projet il vous faudra paramétrer:</p>
<ul>
    <li>L'environnement prod/dev/test</li>
    <li>Générer votre propre clé APP</li>
    <li>La base de donnée</li>
    <li>Le mailer</li>
</ul>