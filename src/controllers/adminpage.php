<?php
namespace Application\Controllers\Adminpage;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Adminpage
{

    public function execute()
    {
        /*===== On récupère les données du pitch =====*/
        // print_r($_SESSION);
        $con = new DatabaseConnection();
        $ligues = $con->getLigues();
        $provinces = $con->getProvinces();
        $departements =  $con->getDepartements();

        // On charge les données des ligues


        /*===== On affiche les données =====*/
        require_once('templates/adminpage.php');

    }

    public function afficheDepartement($id_departement)
    {
        /*===== On récupère les données du département, de sa province, de sa ligue =====*/
        $con = new DatabaseConnection();
        $departement =  $con->getDepartement($id_departement);

        // echo gettype($departement['id_ligue']);
        // echo gettype($departement['nom_ligue']);
        $ligues = array(array('id'=>$departement['id_ligue'], 'nom'=>$departement['nom_ligue']));
        $provinces = array(array('id'=>$departement['id_province'], 'nom'=>$departement['nom_province']));
        $departements =  array($departement);

        /*===== On affiche les données =====*/
        require_once('templates/adminpage.php');

    }

    public function identifie()
    {
        require_once('templates/adminIdentifie.php');
    }

    public function verifieMdp($identifiant, $motDePasse)
    {
        $con = new DatabaseConnection();
        $sql = "SELECT `mdp` FROM `admin` WHERE `identifiant` = ?";
        $donnees = [$identifiant];
        $sth = $con->getConnection()->prepare($sql);
        $sth->execute($donnees);
        $results = $sth->fetch();
        if ($results === False)
        {
            // mauvais identifiant
            $this->erreurMdp();
        } else {
            if (password_verify($motDePasse, $results['mdp']))
            {
                $_SESSION['identifie'] = True;
                $this->execute();
                echo " c'est bon<br>";
            } else {
                $this->erreurMdp();
            }
        }


        // $this->execute();
    }

    protected function erreurMdp()
    {
        $message = "Erreur d'identifiant ou de mot de passe";
        $messageCouleur = "rouge";
        require_once('templates/adminIdentifie.php');
        echo 'coucou';
    }

}

