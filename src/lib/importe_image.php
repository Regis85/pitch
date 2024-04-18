<?php
namespace Application\Lib\ImportImage;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

Class ImportImage
{
    public function execute(): bool
    {
        // echo "Début de la gestion de l'image";
        // print_r($_FILES);

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed))
            die("Erreur : Veuillez sélectionner un format de fichier valide.");

        // Vérifie la taille du fichier - 30Mo maximum
        $maxsize = 30 * 1024 * 1024;
        if ($filesize > $maxsize)
        {
            echo "Error: La taille du fichier est supérieure à la limite autorisée.";
            die("Error: La taille du fichier est supérieure à la limite autorisée.");
        }

        // Vérifie le type MIME du fichier
        if (in_array($filetype, $allowed))
        {
            move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $_FILES["photo"]["name"]);
            // echo "Votre fichier a été téléchargé avec succès.";
        } else {
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
        }

        // On réduit la taille maxi à 3840x2160
        $this->redim_image();

        // On enregistre le nom de la photo
        $image = $this->sauve_image();

        return True;

    }

    protected function sauve_image()
    {
        $mime = $_FILES["photo"]["type"];
        switch ($mime) {
            case 'image/jpeg':
                $image = $_SESSION['id_pitch']. ".jpg";
                break;
            case 'image/png':
                $image = $_SESSION['id_pitch']. ".png";
                break;
            default:
                // throw new Exception('Unknown image type.');
                die("Erreur : " . $mime . " type non reconnu.");
        }


        $database = new DatabaseConnection();
        $database->saveNomImage($image);

        $_SESSION['image'] = $image;

    }

    protected function redim_image()
    {
        $imagename = $_FILES["photo"]["name"];
        $source = $_FILES["photo"]["tmp_name"];

        $repertoire_cible = "photos/";
        $repertoire_depart = "uploads/";

        $imagepath =  $repertoire_depart . $imagename;

        $imagecible = $repertoire_cible . $_SESSION['id_pitch']; // Préparation nouveau nom
        $save = $repertoire_cible . "petite_" . $_SESSION['id_pitch']; // Préparation prtite photo
        //print_r($info);
        $mime = $_FILES["photo"]["type"];

        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $save = $save . ".jpg"; // Nouveau fichier
                $imagecible = $imagecible . ".jpg";
                break;
            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $save = $save . ".png"; // Nouveau fichier
                $imagecible = $imagecible . ".png";
                break;
            default:
                // throw new Exception('Unknown image type.');
                die("Erreur : Format d'image non reconnu.");
        }

        list($width, $height) = getimagesize($imagepath);
        // echo ("<br>taille " . $width . " - " . $height . "<br>");
        if ($width > $height)
        {
            $modwidth = 500;  //target width
            $diff = $width / $modwidth;
            $modheight = $height / $diff;
        } else {
            $modheight = 435;  //target height
            $diff = $height / $modheight;
            $modwidth = $width / $diff;
        }
        $tn = imagecreatetruecolor($modwidth, $modheight);
        imagesavealpha($tn, true);

        $image = $image_create_func($imagepath);
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
        $image_save_func($tn, $save) ;

        rename($imagepath, $imagecible);

    }






/*
        $uploaddir = './uploads/';
        $uploadfile = $uploaddir . basename($_FILES['photo']['name']);

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
        echo "Le fichier est valide, et a été téléchargé avec succès. Voici plus d'informations :\n";
        } else {
        echo "Attaque potentielle par téléchargement de fichiers. Voici plus d'informations :\n";
        }

        echo 'Voici quelques informations de débogage :';
        print_r($_FILES);


    }
*/


}
