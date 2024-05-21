<?php ob_start(); ?>
        <div id='entete'>
            <h1>
                Pitch & Putt
            </h1>
        </div>
<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>
        <ul id='menu'>
            <li><a href="#?cree">Créer</a></li>
            <li><a href="#?affiche">Afficher</a></li>
            <li><a href="#?modifie">Modifier</a></li>
            <li><a href="#?suivre">Suivre</a></li>
        </ul>

<?php $nav = ob_get_clean(); ?>

<?php ob_start(); ?>
        <div id='contenu'>
<?php

?>
        </div>
<?php $content = ob_get_clean(); ?>

<?php require('layoutAdmin.php') ?>
