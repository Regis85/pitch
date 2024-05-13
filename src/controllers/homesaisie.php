<?php

namespace Application\Controllers\Homesaisie;

require_once('src/lib/database.php');
require_once('src/lib/importe_image.php');
require_once('src/lib/user.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Lib\ImportImage\ImportImage;
use Application\Lib\User\User;

class Homesaisie
{
    public function execute()
    {
        /* on vérifie que le visiteur est identifié
         *  - si non : on affiche homesaisie sans possibilité de modification
         *  - si oui : on affiche homesaisie avec possibilité de modification
         * */

        if (isset($_SESSION['connecte']) && $_SESSION['connecte'])
        {
            // responsable de club identifié
            if (isset($_POST))
            {
                $id_golf = $_POST['identifiant'];
                // Des données on été envoyées
                if (isset($_FILES["photo"]))
                {
                    $txtErreur = Null;
                    // On a envoyé une photo
                    if ($_FILES["photo"]["error"] == 0)
                    {
                        // On a téléchargé le fichier
                        $import = new ImportImage();
                        if ($import->execute())
                        {
                            $_SESSION['message']['class'] = "vert";
                            $txtErreur = "Fichier sauvegardé";
                        }
                    } elseif ($_FILES["photo"]["error"] == UPLOAD_ERR_INI_SIZE) {
                        $_SESSION['message']['class'] = "rouge";
                        $txtErreur = "La photo est trop grande (30Mo maxi)";
                    } elseif ($_FILES["photo"]["error"] == UPLOAD_ERR_FORM_SIZE) {
                        $_SESSION['message']['class'] = "rouge";
                        $txtErreur = "Le fichier photo est trop grand (30Mo maxi)";
                    } elseif (isset($_FILES["name"]) && $_FILES["name"])  {
                        $_SESSION['message']['class'] = "rouge";
                        $txtErreur = "Erreur " . $_FILES['doc']['error'] ." lors du téléchargement";
                    }
                    $_SESSION['message']['texte'] = $txtErreur;
                }
                // Enregistrement des dirigeants
                if (isset($_POST['gerant']))
                {
                    $newDirigeant = new User();
                    $newDirigeant->chargeUser($_POST['id_Gerant'], $_POST['gerant'],
                                $_POST['gerantTel'], $_POST['gerantCourriel'], 1);
                    $newDirigeant->enregistreUser();
                    $newDirigeant->lieGolf($id_golf);
                }

                if (isset($_POST['presidentAS']))
                {
                    $newAS = new User();
                    $newAS->chargeUser($_POST['id_AS'], $_POST['presidentAS'],
                                $_POST['asTel'], $_POST['asCourriel'], 2);
                    $newAS->enregistreUser();
                    $newAS->lieGolf($id_golf);
                }

                if (isset($_POST['cppf']))
                {
                    $newCPPF = new User();
                    $newCPPF->chargeUser($_POST['id_CPPF'], $_POST['cppf'],
                                $_POST['cppfTel'], $_POST['cppfCourriel'], 3);
                    $newCPPF->enregistreUser();
                    $newCPPF->lieGolf($id_golf);
                }

                if (isset($_POST['nouveauPro']))
                {
                    $newPro = new User();
                    $newPro->chargeUser($_POST['id_nouveauPro'], $_POST['nouveauPro'],
                                $_POST['nouveauProTel'], $_POST['nouveauProCourriel'], 4);
                    $newPro->enregistreUser();
                    $newPro->lieProGolf($id_golf);
                }

            }
            $disabled = "";
            $cacherConnect = ""; $cacherEnregistre = "";
        } else {
            // responsable de club non-identifié.
            $disabled = "disabled";
            $cacherConnect = ""; $cacherEnregistre = "hidden";
        }

        if (isset($_SESSION['mdp']) && $_SESSION['mdp'] && !$_SESSION['connecte'])
        {
            // Le mot de passe n'est pas bon
            $_SESSION['message']['class'] = "rouge";
            $_SESSION['message']['texte'] = "Le mot de passe est invalide";
        }

        // On affiche la page de saisie
        require('templates/homesaisie.php');
        $_SESSION['message'] = [];

    }

}
