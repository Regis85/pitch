<?php
namespace Application\Controllers\Adminpage;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Adminpage
{
    public DatabaseConnection $connexion;

    public function identifie()
    {
        require_once('templates/adminIdentifie.php');
    }

    public function execute()
    {
        $this->connexion = new DatabaseConnection();
        $ligueActive = Null;
        $provinceActive = Null;
        $departementActif = Null;

        // On charge les données pour le menu
        if (isset($_POST['soumettre']) && $_POST['soumettre'] == 'select'
                    && isset($_SESSION['lastSelection'])) {
            /*===== On a déjà afficher une page, on sélectionne ce qu'on affiche =====*/

            //----- La ligue a changée, on efface la province sélectionnée et le département sélectionné
            if($_POST['selectLigue'] != $_SESSION['lastSelection']['ligue']) {
                $ligueActive = $_POST['selectLigue'];
                $ligues = $this->afficheLigue($ligueActive);

                $_SESSION['lastSelection']['ligue'] = $_POST['selectLigue'];

                // il n'y a plus de département actif
                $departementActif = Null;
                // il n'y a plus de province active
                $provinceActive = Null;
                // On récupère les provinces de la ligue
                if ($ligueActive) {
                    $provinces = $this->getProvincesByLigue($ligueActive);
                } else {
                    $provinces = $this->connexion->getProvinces($ligueActive);
                }

                // On récupère les départements de la ligue
                if ($ligueActive) {
                    $departements = $this->getDepartementsByLigue($ligueActive);
                } else {
                    $departements = $this->connexion->getDepartements();
                }

            //----- La province a changée, on récupère sa ligue, on efface le département sélectionné
            } elseif ($_POST['selectProvince'] != $_SESSION['lastSelection']['province']) {

                $provinceActive = $_POST['selectProvince'];

                // mettre à jour la ligue active
                if ($provinceActive) {
                    $ligueActive = $this->getLigueByDepartement($_POST['selectProvince'])['id_ligue'];
                }

                $_SESSION['lastSelection']['province'] = $_POST['selectProvince'];

                // il n'y a plus de département actif
                $departementActif = Null;

                /*===== On récupère les données du menu =====*/
                $ligues = $this->afficheLigue();
                $provinces = $this->connexion->getProvinces($ligueActive);
                $departements =  $this->getDepartementByProvince($provinceActive);

            //----- Le département à changé, on récupère sa province et sa ligue
            } elseif ($_POST['selectDepartement'] != $_SESSION['lastSelection']['departement']) {

                // On met à jour le département actif
                $departementActif = $_POST['selectDepartement'];
                $_SESSION['lastSelection']['departement'] = $departementActif;

                // mettre à jour la province active
                $provinceActive = $this->getProvinceByDepartement($departementActif)['id_province'];
                $_SESSION['lastSelection']['province'] = $provinceActive;

                // mettre à jour la ligue active
                $ligueActive = $this->getLigueByDepartement($departementActif)['id_ligue'];
                $_SESSION['lastSelection']['ligue'] = $ligueActive;

                /*===== On récupère les données du menu =====*/
                $ligues = $this->afficheLigue();
                $provinces = $this->connexion->getProvinces($ligueActive);
                $departements =  $this->getDepartementByProvince($provinceActive);

            } else {
                die("adminpage.php : il faut gérer ce cas");
            }

        } else {
            // premier affichage
            $_SESSION['lastSelection'] = array("ligue" => Null,
                                            "province" => Null,
                                            "departement" => Null,
                                            "pitch" => Null);

            /*===== On récupère les données du menu =====*/
            $ligues = $this->afficheLigue($ligueActive);
            $provinces = $this->connexion->getProvinces($ligueActive);
            $departements =  $this->connexion->getDepartements($ligueActive, $provinceActive, $departementActif);
        }
        /*===== On récupère les données du pitch =====*/

        /*===== On affiche les données =====*/
        require_once('templates/adminpage.php');

    }

    public function afficheLigue(): array
    {
        $this->connexion = new DatabaseConnection();
        $envoi = array();
        $sql = "SELECT * FROM  `ligues`";

        try {
            $sth = $this->connexion->getConnection()->prepare($sql);
            $sth->execute($envoi);
            return $sth->fetchall();
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }

    }

    public function afficheDepartement($id_departement)
    {
        /*===== On récupère les données du département, de sa province, de sa ligue =====*/
        $con = new DatabaseConnection();
        $departement =  $con->getDepartement($id_departement);

        $ligues = array(array('id'=>$departement['id_ligue'], 'nom'=>$departement['nom_ligue']));
        $provinces = array(array('id'=>$departement['id_province'], 'nom'=>$departement['nom_province']));
        $departements =  array($departement);

        /*===== On affiche les données =====*/
        require_once('templates/adminpage.php');

    }

    public function verifieMdp($identifiant, $motDePasse): Bool
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
            return False;
        } else {
            if (password_verify($motDePasse, $results['mdp']))
            {
                $_SESSION['identifie'] = True;
                $_SESSION['results'] = 'essai';
                $_SESSION['result'] = $results;
                return True;
            } else {
                $this->erreurMdp();
                return False;
            }
        }

    }

    protected function erreurMdp()
    {
        // Erreur d'identifiant on revient sur la page d'identification
        $message = "Erreur d'identifiant ou de mot de passe";
        $messageCouleur = "rouge";
        require_once('templates/adminIdentifie.php');

    }

    protected function getLigueActive($province): int
    {
        $con = new DatabaseConnection();
        $sql = "SELECT `id_ligue` FROM `provinces` WHERE id = ? ";
        $donnees = [$province];

        try {
            $sth = $con->getConnection()->prepare($sql);
            $sth->execute($donnees);
            $result = $sth->fetch();
            return $result;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }

    }

    protected function getProvincesByLigue($ligue): array
    {
        $con = new DatabaseConnection();
        $sql = "SELECT * FROM `provinces` WHERE `id_ligue` = ? ";
        $donnees = [$ligue];

        try {
            $sth = $con->getConnection()->prepare($sql);
            $sth->execute($donnees);
            $result = $sth->fetchall();
            return $result;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    protected function getDepartementsByLigue($ligue): array
    {
        $con = new DatabaseConnection();
        $sql = "SELECT d.* FROM `departements` as d LEFT JOIN
                (SELECT * FROM `provinces`) as p ON p.id = d.id_province
                WHERE p.`id_ligue` = ?; ";
        $donnees = [$ligue];

        try {
            $sth = $con->getConnection()->prepare($sql);
            $sth->execute($donnees);
            $result = $sth->fetchall();
            return $result;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    protected function getLigueByDepartement($province): array
    {
        $con = new DatabaseConnection();

        $sql = "SELECT p.`id_ligue` FROM `provinces` as p LEFT JOIN
                    (SELECT `id_province`, `id` FROM `departements` ) as d
                    ON d.id_province = p.id
                    WHERE d.`id` = ?; ";
        $donnees = [$province];

        try {
            $sth = $con->getConnection()->prepare($sql);
            $sth->execute($donnees);
            $result = $sth->fetch();
            return $result;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    protected function getDepartementByProvince($province): array
    {
        $con = new DatabaseConnection();
        $sql = "SELECT * FROM `departements` WHERE id_province = ?; ";
        $donnees = [$province];

        try {
            $sth = $con->getConnection()->prepare($sql);
            $sth->execute($donnees);
            $result = $sth->fetchall();
            return $result;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    protected function getProvinceByDepartement($departement): array
    {
        $con = new DatabaseConnection();
        $sql = "SELECT `id_province` FROM `departements` WHERE `id` = ?; ";
        $donnees = [$departement];

        try {
            $sth = $con->getConnection()->prepare($sql);
            $sth->execute($donnees);
            $result = $sth->fetch();
            return $result;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

}

