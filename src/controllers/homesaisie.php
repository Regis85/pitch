<?php

namespace Application\Controllers\Homesaisie;

require_once('src/lib/database.php');
require_once('src/lib/importe_image.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Lib\ImportImage\ImportImage;

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
                // Des données on été envoyées
                if (isset($_FILES["photo"]))
                {
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
                    } elseif ($_FILES["name"])  {
                        $_SESSION['message']['class'] = "rouge";
                        $txtErreur = "Erreur " . $_FILES['doc']['error'] ." lors du téléchargement";
                    }
                    $_SESSION['message']['texte'] = $txtErreur;
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
