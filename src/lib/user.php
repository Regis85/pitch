<?php
namespace Application\Lib\user;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class User
{
    public $id;
    public String $nom;
    public String $telephone;
    public String $courriel;
    public int $statut;          // id du statut : 1 dirigeant, 2 AS, 3 CPPF, 4 Pro

    public DatabaseConnection $connection;

    public function chargeUser($id, $nom, $telephone, $courriel, $statut)
    {
        $this->id = intval($id);
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->courriel = $courriel;
        $this->statut = $statut;

    }

    public function enregistreUser():bool
    {
        $this->connection = new DatabaseConnection();
        // On enregistre l'utilisateur
        if ($this->id == 0)
        {
            // Nouvel utilisateur
            $sql = "INSERT INTO `prive` (`id`, `Nom`, `telephone`, `courriel`, `statut`)
                    VALUES (?, ?, ?, ?, ?); ";
            $envoi = array($this->id, $this->nom, $this->telephone, $this->courriel, $this->statut);
        } else {
            // Mise à jour
            $sql = "UPDATE `prive`
                    SET `Nom` = ?, `telephone` = ?, `courriel` = ?,
                        `statut` = ? WHERE `id` = ?; ";
            $envoi = array($this->nom, $this->telephone, $this->courriel, $this->statut, $this->id);
        }

        try {
            $sth = $this->connection->getConnection()->prepare($sql);
            $sth->execute($envoi);

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }

        return true;
    }

    public function lieGolf($id_golf):bool
    {
        echo "lire les dirigeants du Golf ";
        return true;
    }

    public function lieProGolf($id_golf):bool
    {
        echo "lieProGolf";
        return true;
    }

}
