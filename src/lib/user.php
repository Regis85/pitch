<?php
namespace Application\Lib\User;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class User
{
    public $id;
    public String $nom;
    public String $telephone;
    public String $courriel;
    public int $id_pitch;
    public int $status;          // id du status : 1 dirigeant, 2 AS, 3 CPPF, 4 Pro

    public DatabaseConnection $connection;

    public function chargeUser($id, $nom, $telephone, $courriel, $id_pitch, $status)
    {
        $this->id = intval($id);
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->courriel = $courriel;
        $this->id_pitch = (int)$id_pitch;
        $this->status = $status;

    }

    public function enregistreUser():bool
    {
        $this->connection = new DatabaseConnection();
        // On enregistre l'utilisateur
        /*
        if ($this->id == 0)
        {
            // Nouvel utilisateur
            $sql = "INSERT INTO `prive` (`id`, `Nom`, `telephone`, `courriel`, `status`)
                    VALUES (?, ?, ?, ?, ?); ";
            $envoi = array($this->id, $this->nom, $this->telephone, $this->courriel, $this->status);
        } else {
            // Mise à jour
            $sql = "UPDATE `prive`
                    SET `Nom` = ?, `telephone` = ?, `courriel` = ?,
                        `status` = ? WHERE `id` = ?; ";
            $envoi = array($this->nom, $this->telephone, $this->courriel, $this->status, $this->id);
        }
        */

        $envoi = array($this->id, $this->nom, $this->telephone, $this->courriel);
        array_push($envoi, $this->id_pitch, $this->status);
        array_push($envoi, $this->nom, $this->telephone, $this->courriel);

        $sql = "INSERT INTO `prive`  (`id`, `Nom`, `telephone`, `courriel`, `id_golf`, `status`)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        `Nom` = ?,
                        `telephone` = ?,
                        `courriel` = ? ";

        try {
            $sth = $this->connection->getConnection()->prepare($sql);
            $sth->execute($envoi);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }

        return true;
    }

    public function lieGolf($id_golf, $status):bool
    {
        // Lire les dirigeants du Golf ";
        $dirigeants = $this->connection->chargeDirigeants($_SESSION['club']['id']);
        $_SESSION['club']['dirigeants'] = $dirigeants;
        return true;
    }

    public function lieProGolf($id_golf):bool
    {
        echo "lieProGolf";
        return true;
    }

}
