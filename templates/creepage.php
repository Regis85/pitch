<?php ob_start(); ?>
        <div id='entete'>
            <h1>
                Pitch & Putt
            </h1>
        </div>

<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>

        <div id='pitch'>
<?php if (isset($_SESSION['message']) && $_SESSION['message']['texte']) { ?>
            <p class="centre <?= $_SESSION['message']['class']; ?>">
                <?= $_SESSION['message']['texte']; ?>
                <?php $_SESSION['message']['texte'] = Null; ?>
            </p>
<?php } ?>

        <form id='cree' method="POST" >
            <ul id='menu'>
                <li><button name='cree' value='sauve' >Enregistrer</button></li>
                <li><button name='cree' value='quitte' >Abandonner</button></li>
            </ul>

            <p>
                <label for='selectDepartement' >Département : </label>
                <select name="selectDepartement" id="selectDepartement" >
<?php foreach($departements as $departement) { ?>
                    <option value=<?= $departement['code'] ?>
<?php if ($departementActif && $departement['id'] == $departementActif) { ?>
                            selected
<?php } ?> >
                        <?= $departement['nom'] ?>
                    </option>
<?php } ?>
                </select>
            </p>
            <p>
                <label for='nom' >Nom du golf : </label>
                <input type='text' id='nom' name='nom' class='champLarge' />
            </p>
            <p>
                <label for='telephone : ' >Téléphone : </label>
                <input type='text' id='telephone : ' name='telephone' />
            </p>
            <p>
                <label for='courriel' >Courriel : </label>
                <input type='text' id='courriel' name='courriel' class='champLarge' />
            </p>
            <p>
                <label for='gps' title='en degrés ##0.0####' >Coordonnées GPS (Lat/Lon) : </label>
                <input type='text' id='gps' name='gps' />
            </p>
            <p>
                <label for='web' >Site Web : </label>
                <input type='text' id='web' name='web' class='champLarge' />
            </p>
                <label for='mdp' >Mot de passe : </label>
                <input type='password' id='mdp'  name='mdp' class='champLarge' />
            </p>
            </p>
                <label for='suivi' >Suivi par : </label>
                <select id='suivi'  name='suivi'>
<?php foreach($admins as $admin) { ?>
                    <option value=<?= $admin['id'] ?>>
                        <?= $admin['nom'] ?> <?= $admin['prenom'] ?>
                    </option>
<?php } ?>

                </select>
            </p>


        </form>
        </div>


<?php $content = ob_get_clean(); ?>

<?php require('layoutAdmin.php') ?>
