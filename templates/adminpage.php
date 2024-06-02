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
        <form id='deconnecte' method="POST" >
            <!-- formulaire pour se déconnecter -->
        </form>
        <form id='selection' method="POST">
<p><?= $ligueActive ?></p>
            <p>
                Ligue :
                <select name="selectLigue" id="selectLigue">
<?php if ($ligues && count($ligues) > 1) { ?>
                    <option value="">-</option>
<?php } ?>
<?php foreach($ligues as $ligue) {
    echo $ligue['id'] ; ?>
                    <option value=<?= $ligue['id'] ?>
                        <?php if ($ligueActive && $ligue['id'] == $ligueActive) { ?>
                            selected
                        <?php } ?> >
                        <?= $ligue['nom'] ?>
                    </option>
<?php } ?>
                </select>
            </p>
            <p>
                Province :
                <select name="selectProvince" id="selectProvince">
<?php if ($provinces && count($provinces) > 1) { ?>
                    <option value="">-</option>
<?php } ?>
<?php foreach($provinces as $province) { ?>
                    <option value=<?= $province['id'] ?>><?= $province['nom'] ?></option>
<?php } ?>
                </select>
            </p>
            <p>Département
                <select name="selectDepartement" id="selectDepartement">
<?php if ($departements && count($departements) > 1) { ?>
                    <option value="">-</option>
<?php } ?>
<?php foreach($departements as $departement) { ?>
                    <option value=<?= $departement['id'] ?>><?= $departement['nom'] ?></option>
<?php } ?>
                </select>
            </p>
            <p><button name="soumettre" value="select">Sélectionner</button></p>
            <p><button form="deconnecte" name="soumettre" value="deconnecte">Se déconnecter</button></p>
        </form>

<?php $nav = ob_get_clean(); ?>

<?php ob_start(); ?>
        <div id='contenu'>
            <p>
<?php
    print_r($_POST);
    echo "<br><br>";
    print_r($_SESSION);
    echo "<br>";
?>
            </p>
        </div>
<?php $content = ob_get_clean(); ?>

<?php require('layoutAdmin.php') ?>
