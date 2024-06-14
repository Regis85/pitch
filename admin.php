<?php

require_once('src/controllers/adminpage.php');
require_once('src/controllers/creepage.php');

use Application\Controllers\Adminpage\Adminpage;
use Application\Controllers\Creepage\Creepage;
// On démarre une nouvelle session
session_start();

$adminpage = new Adminpage();
$creepage = new Creepage();

print_r($_POST);
/*
print_r($_GET);
echo "<br> SESSION <br>";
print_r($_SESSION);
* */

if (isset($_POST['cree']) && $_POST['cree'] == "nouveau" && $_SESSION['identifie']) {
    // On crée un nouveau club
// echo "<br>on crée un nouveau club<br>";
    $creepage->execute();

} elseif (isset($_POST['cree']) && $_POST['cree'] == "sauve" && $_SESSION['identifie']) {
    // On crée un nouveau pitch
    $adminpage->sauvePitch();


} elseif (isset($_POST['soumettre']) && $_POST['soumettre'] === 'deconnecte') {
    // On se déconnecte
    $_SESSION = array();
    $adminpage->identifie();
} elseif (isset($_POST['Submit']) && $_POST['Submit'] === 'Submit') {
    // Quelqu'un essai de se connecter
    if ($_POST['identifiant'] =="" or $_POST['mdp'] =="") {
        $adminpage->identifie();
        die;
    } else {
        // Vérifier si les identifiants sont bons

        if (isset($_POST['identifie']) && $_POST['identifie']) {

            if ($adminpage->verifieMdp($_POST['identifiant'], $_POST['mdp']))
            {
                // Identification réussie
                $adminpage->execute();
                die();
            } else {
                // Erreur d'identifiants ;
                die();
            }
        }
    }

} elseif (isset($_SESSION['identifie']) && $_SESSION['identifie']) {

    if (isset($_POST['soumettre']) && $_POST['soumettre'] == 'select') {
        // on affiche la page par défaut
        $adminpage->execute();

    } else {
        $adminpage->execute();
    }

} else {
    $adminpage->identifie();
}




