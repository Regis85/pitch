<?php

require_once('src/controllers/adminpage.php');

use Application\Controllers\Adminpage\Adminpage;
// On démarre une nouvelle session
session_start();

$adminpage = new Adminpage();

if (isset($_SESSION['identifie']) && $_SESSION['identifie'])
{

    if (isset($_POST) && isset($_POST['soumettre']) && $_POST['soumettre'] == "deconnecte") {
        // On se déconnecte
        $_SESSION = [];
        session_reset();
        session_abort();
        $adminpage->identifie();
    } elseif (isset($_POST)) {
        // Des données sont passées
        if (isset($_POST['selectDepartement']) && $_POST['selectDepartement'] != "") {
            // Un département a été choisi
            $adminpage->afficheDepartement($_POST['selectDepartement']);

        } elseif (isset($_POST['selectProvince']) && $_POST['selectProvince'] != "") {
            // Une province a été choisie

        } elseif (isset($_POST['selectLigue']) && $_POST['selectLigue'] != "") {
            // Une ligue a été choisie

        }
        // on affiche la page par défaut
        $adminpage->execute();
    }


} elseif (isset($_POST['identifie']) && $_POST['identifie']){

    $adminpage->verifieMdp($_POST['identifiant'], $_POST['mdp']);

} else {

    $adminpage->identifie();

}


