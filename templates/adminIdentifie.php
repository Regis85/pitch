<?php ob_start(); ?>
        <div id='entete'>
            <h1>
                Pitch & Putt
            </h1>
        </div>
<?php $header = ob_get_clean(); ?>


<?php ob_start(); ?>


    <form  id='identifie' action='admin.php' class='centre' method="POST" >
<?php if (isset($message)) { ?>
        <p class="<?php if ($messageCouleur) { echo $messageCouleur; } ?>" >
            <?= $message ?>
        </p>
<?php } ?>
        <input type='hidden' id='identifie' name='identifie' value=True />
        <p class='titre rouge'>
            Saisissez vos identifiant
        </p>
        <p>
            <label for='identifiant' >Identifiant : </label>
            <input type='text' id='identifiant' name='identifiant' />
        </p>
        <p>
            <label for='mdp' >Mot de passe : </label>
            <input type='text' id='mdp' name='mdp' />
        </p>
        <p>
            <button type="submit" value="Submit">Soumettre</button>
        </p>
    </form>



<?php $content = ob_get_clean(); ?>

<?php require('layoutAdmin.php') ?>


