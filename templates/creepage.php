<?php ob_start(); ?>
        <div id='entete'>
            <h1>
                Pitch & Putt
            </h1>
        </div>
<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>

        <form id='cree' method="POST" >
            <ul id='menu'>
                <li><button name='cree' value='sauve' >Enregistrer</button></li>
                <li><button name='cree' value='quitte' >Abandonner</button></li>
            </ul>

        </form>


<?php $content = ob_get_clean(); ?>

<?php require('layoutAdmin.php') ?>
