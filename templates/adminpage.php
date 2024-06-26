<?php ob_start(); ?>
        <div id='entete'>
            <h1>
                Pitch & Putt
            </h1>
        </div>
<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>

<?php if (isset($_SESSION['message']) && $_SESSION['message']['texte']) { ?>
        <p class="<?= $_SESSION['message']['class']; ?>">
            <?= $_SESSION['message']['texte']; ?>
            <?php $_SESSION['message']['texte'] = Null; ?>
        </p>
<?php } ?>

        <form id='deconnecte' method="POST" >
            <!-- formulaire pour se déconnecter -->
            <!-- le bouton est plus bas -->
        </form>
        <form id='selection' method="POST">
            <p>
                Ligue :
                <select name="selectLigue" id="selectLigue" >
<?php if ($ligues && count($ligues) > 1) { ?>
                    <option value="">-</option>
<?php } ?>
<?php foreach($ligues as $ligue) { ?>
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
                <select name="selectProvince" id="selectProvince" >
<?php if ($provinces && count($provinces) > 1) { ?>
<?php   if (!$provinceActive) { ?>
                    <option value="">-</option>
<?php   } ?>
<?php } ?>
<?php foreach($provinces as $province) { ?>
                    <option value=<?= $province['id'] ?>
                        <?php if ($provinceActive && $province['id'] == $provinceActive) { ?>
                            selected
                        <?php } ?> >
                        <?= $province['nom'] ?>
                    </option>
<?php } ?>
                </select>
            </p>
            <p>Département
                <select name="selectDepartement" id="selectDepartement" >
<?php if ($departements && count($departements) > 1) { ?>
<?php   if (!$departementActif) { ?>
                    <option value="">-</option>
<?php   } ?>
<?php } ?>
<?php foreach($departements as $departement) { ?>
                    <option value=<?= $departement['id'] ?>
                        <?php if ($departementActif && $departement['id'] == $departementActif) { ?>
                            selected
                        <?php } ?> >
                        <?= $departement['nom'] ?>
                    </option>
<?php } ?>
                </select>
            </p>
            <p><button name="soumettre" value="select">Sélectionner</button></p>
            <p><button form="deconnecte" name="soumettre" value="deconnecte">Se déconnecter</button></p>
        </form>

<?php $nav = ob_get_clean(); ?>

<?php ob_start(); ?>

        <form id='selectionPitch' method="POST">

        <ul id='menu'>
            <li><button name='cree' value='nouveau' >Nouveau</button></li>
            <li><button name='cree' value='modifie' >Modifier</button></li>
            <li><button name='cree' value='supprime' >Supprimer</button></li>
        </ul>

        <div id='contenu'>
            <table id='pitchs'>
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Nom</th>
                        <th>Courriel</th>
                        <th>gps Lat/long</th>
                        <th>Site Web</th>
                        <th>Département</th>
                        <th>Suivi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($pitchs as $pitch) { ?>
                    <tr>
                        <td><?= $pitch['identifiant'] ?></td>
                        <td><?= $pitch['nom'] ?></td>
                        <td><?= $pitch['courriel'] ?></td>
                        <td><?= $pitch['gps'] ?></td>
                        <td>
                            <a href="<?= $pitch['siteWeb'] ?>" target = "_blanc">
                                <?= $pitch['siteWeb'] ?>
                            </a>
                        </td>
                        <td><?= $pitch['departement'] ?></td>
                        <td><?= $pitch['administrateur'] ?></td>
                        <td>
                            <input type='radio' name='id_pitch' value="<?= $pitch['id'] ?>" />
                        </td>
                    </tr>

<?php } ?>
                </tbody>

            </table>

        </form>

        </div>
<?php $content = ob_get_clean(); ?>

<?php require('layoutAdmin.php') ?>
