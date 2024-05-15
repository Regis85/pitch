
<?php ob_start(); ?>
        <!-- --<?= print_r($_SESSION); ?> <!-- -->
        <div class='entete'>
            <h1>
                Pitch & Putt
            </h1>
            <p class="center">Changement du mot de passe</p>
        </div>
<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>

    <form method="POST" >
        <input type="hidden" id="changeMdp" name="changeMdp" value="1" />
        <input type="hidden" id="connecte" name="connecte" value="<?= $_SESSION['connecte']; ?>" />
        <p class="center">
            <label for="ancienMdp">Ancien mot de passe *</label>
            <input type="password" id="ancienMdp" name="ancienMdp" title="Mot de passe actuel" />
        </p>
        <p class="center">
            <label for="nouveauMdp">Nouveau mot de passe *</label>
            <input type="password" id="nouveauMdp" name="nouveauMdp" size="24" minlength="8"
                    pattern="[A-Za-z0-9]*[A-Za-z]+[A-Za-z0-9]*[0-9]+[A-Za-z0-9]*{8}"
                    title="Au moins 8 caractères dont au moins 1 lettre et 1 chiffre"
                    />
        </p>
        <p class="center">
            <label for="verifMdp">Vérification du mot de passe *</label>
            <input type="password" id="verifMdp" name="verifMdp"
                    title="Saisissez à nouveau votre nouveau mot de passe"
                    />
        </p>
        <p class="center">
            <button name="soumet" type="submit" value="enregistre" >Enregistrer</button>
            <button name="soumet" type="submit" value="annule"
    title="Pour annuler le nouveau mot de passe doit être vide ou avoir au moins 8 caractères." >
                Annuler
            </button>
        </p>
        <p>
            * Champ obligatoire
        </p>
    </form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
