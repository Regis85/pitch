<?php $title = "Pitch Golf : erreur"; ?>

<?php ob_start(); ?>
<h1>Erreur lors de l'affichage d'un pitch</h1>
<p>Une erreur est survenue : <?= $errorMessage ?></p>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
