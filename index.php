<?php

require_once('src/controllers/homepage.php');
require_once('src/controllers/homesaisie.php');
require_once('src/lib/connect.php');
require_once('src/lib/change_mdp.php');
require_once('src/lib/database.php');

use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Homesaisie\Homesaisie;
use Application\Lib\Connect\ConnectRepository;
use Application\Lib\ChangeMdp\ChangeMdp;
use Application\Lib\Database\DatabaseConnection;

// On démarre une nouvelle session
session_start();

$_SESSION['mdp'] = False;
/* *
print_r($_POST);
echo "<br>=====<br>";
print_r($_GET);
echo "<br>=====<br>";
print_r($_SESSION);
echo "<br>=====<br>";
// print_r($_FILES);
* */

if (isset($_GET['saisie']) && $_GET['saisie'] != "")
{
    // On récupère les données du club
    $connect = new ConnectRepository();
    $connecte = $connect->connectUser();
    $_SESSION['id_pitch'] = $_GET['saisie'];
    if (isset($_POST['id_soumit'])  && $_POST['id_soumit'] === "connect")
    {
        $_SESSION['mdp'] = True;
        if (isset($_POST['mdp']))
        {
            // si un mot de passe a été envoyé
            // Un utilisateur essaie de se connecter
            if ($_SESSION['connecte']) {
                // le mot de passe est correct, on peut modifier la page
                $homesaisie = new Homesaisie();
                $homesaisie->execute();

            } else {
                // On affiche la page non connecté
                $homesaisie = new Homesaisie();
                $homesaisie->execute();
            }
        }
    } elseif (isset($_POST['id_soumit']) &&  $_POST['id_soumit'] === "mdp"){
        // Un utilisateur veut changer le mot de passe
        $saveMdp = new ChangeMdp();
        $saveMdp->execute();
    } elseif (isset($_POST['changeMdp']) &&  $_POST['changeMdp'] == "1"){
        // Un utilisateur essaie de changer le mot de passe
        $saveMdp = new ChangeMdp();
        $sauveMdp = $saveMdp->verifieMdp(); // On vérifie que le mot de passe peut être changer

        if (!$sauveMdp) {
            $homesaisie = new Homesaisie();
            $homesaisie->execute();
        }

        $homesaisie = new Homesaisie();
        $homesaisie->execute();

    } elseif (isset($_POST['id_soumit']) &&  $_POST['id_soumit'] === "Quitter"){
        // On retourne sur pitchgolf.fr
        retourPitchGolf();
    } elseif (isset($_POST['id_soumit']) &&  $_POST['id_soumit'] === "donnees"){
        // Si on envoie des données
        if ($_SESSION['connecte'] !==$_POST['connecte']) {
            $_SESSION['connecte'] = Null;
        } else {
            if ((new DatabaseConnection())->enregistreDonnees($_POST))
            {
                $connecte = $connect->connectUser();
            }
        }
        $homesaisie = new Homesaisie();
        $homesaisie->execute();
    } else {
        // Sinon on affiche la page non connecté
        $_SESSION['connecte'] = Null;
        $homesaisie = new Homesaisie();
        $homesaisie->execute();
    }
}
elseif (isset($_GET['pitch']) && $_GET['pitch'] != "")
{
    /* ===== Affichage de données ===== */
    $_SESSION = [];
    $_SESSION['id_pitch'] = $_GET['pitch'];
    $homepage = new Homepage();
    $homepage->execute();

}
else
{
    // pour l'instant rien, ensuite Retour à la page de Pitchgolf/parcours
    // header('Location: https://pitchgolf.fr/les-parcours/');
    echo "Vous devez indiquez un numéro de golf";
    session_destroy();
    die();
}


function retourPitchGolf(){
    // Retour à la page de Pitchgolf/parcours
    session_destroy();
    header('Location: https://pitchgolf.fr/les-parcours/');
    die();
}

