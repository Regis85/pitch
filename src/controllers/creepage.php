<?php
namespace Application\Controllers\Creepage;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Creepage
{
    public DatabaseConnection $connexion;

    public function execute()
    {
/*
echo "<br>GET<br>";
print_r($_GET);
echo "<br>POST<br>";
print_r($_POST);
echo "<br> SESSION <br>";
print_r($_SESSION);
* */

        $this->connexion = new DatabaseConnection();

        if ($_SESSION['identifie'] != 1) {
            echo "Vous n'êtes pas identifié";
            $_SESSION = array();
            die;
        } else {
            if ($_POST['cree'] == 'nouveau') {
                //----- Créer un nouveau pitch -----
                // Récupérer département dans $_SESSION

                $departementActif = isset($_SESSION['lastSelection']['departement']) ? $_SESSION['lastSelection']['departement'] : Null;

                $departements = $this->connexion->getDepartements();

            } elseif ($_POST['cree'] == 'modifie') {
                //----- Modifie un pitch -----
                // Récupérer département, province et ligue du pitch

            } elseif ($_POST['cree'] == 'sauve') {
                //-----  Enregistrer les données -----
                echo "<br> Enregistrement de données";
            } elseif ($_POST['cree'] == 'quitte') {
                //-----  On quitte sans enregistrer -----
                echo "<br> On quitte sans enregistrer";
                header('Location: ./admin.php');
                exit();

            }


        }

        /*===== On affiche la page =====*/
        require_once('templates/creepage.php');

    }

}
