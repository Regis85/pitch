<?php

namespace Application\Lib\Database;

class DatabaseConnection
{

    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        // Récupération d'un accès à la base
        if ($this->database === null)
        {
            require 'identifiants.php';

            try {
                $this->database = new \PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return $this->database;
    }

    public function toString(): String
    {
        // Affichage en clair des données de la connexion
        if  ($this->database === null)
        {
            return "Connexion non définie";
        } else {
            return "mysql:host=localhost;dbname=pitchgolf;charset=utf8', 'pitch_user'";
        }
    }

    public function getPitch($idPitch)
    {
        // Récupération des données d'un pitch dans la base
        $sql = "SELECT * FROM pitch WHERE identifiant = ? ";
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute([$idPitch]);
        $result = $sth->fetch();
        return $result;
    }

    public function getTrous($idPitch): array
    {
        // Récupération des données des trous d'un pitch à partir de son identifiant
        $sql = "SELECT t.longueur FROM trous as t LEFT JOIN pitch as p ON t.id_golf = p.id
                    WHERE p.identifiant = ?; " ;
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute([$idPitch]);
        $results = $sth->fetchall();

        return $results;
    }

    public function chargeDirigeants($idPitch):array
    {
        // Récupération des données des dirigeants à partir de l'identifiant du pitch
        $sql = "SELECT pi.* FROM `prive` as pi
            WHERE pi.status <> ? AND pi.id_golf = ?
            ORDER BY pi.status;";
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute([4, $idPitch]);
        $results = $sth->fetchall();

        return $results;
    }

    public function enregistreMdp($mdp, $id_club): bool
    {
        // Enregistre le mot de passe
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $envoi = [$mdp, $id_club];
        try {
            $sql = "UPDATE `pitch` SET `motDePasse` = ? WHERE `identifiant` = ?";
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute($envoi);

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
        return true;
    }

    public function enregistreDonnees($donnees): bool
    {
        // Enregistrement des données d'un pitch
        $envoi = [$donnees['name'], $donnees['gps'], $donnees['pitchCompact'] == "on" ? 1 : 0,
                (int)$donnees['green'], (int)$donnees['tee'],(int)$donnees['greens'],
                (int)$donnees['tees'], $donnees['competition'] == "on" ? 1 : 0,
                $donnees['training'] == "on" ? 1 : 0, (int)$donnees['long'],
                $donnees['entraine'] == "on" ? 1 : 0, (int)$donnees['club'], (int)$donnees['sac'],
                $this->espaces($donnees['tarifs']), $this->espaces($donnees['heures']),
                isset($donnees['resto']) && $donnees['resto'] == "on" ?
                    1 : 0,
                isset($donnees['restoRapide']) && $donnees['restoRapide'] == "on" ? 1 : 0,
                $this->espaces($donnees['menuRapide']), $this->espaces($donnees['acces']),
                $donnees['web'],
                $donnees['phone'], $donnees['courriel'], $this->espaces($donnees['actualites']),
                $_SESSION['id_pitch']];

        try {
            $sql = "UPDATE `pitch`
                    SET `nom` = ?, `gps` = ?, `pitch` = ?, `nbGreen` = ?, `nbDepart` = ?,
                        `greenSynthe` = ?, `departSynthe` = ?, `competition` = ?,
                        `entrainement` = ?, `longTotale` = ?, `zoneEntrainement` = ?,
                        `locationClubs` = ?, `locationSac` = ?, `tarifs` = ?, `horaires` = ?,
                        `restaurant` = ?, `restauRapide` = ?, `horaireRestau` = ?,
                        `acces` = ?, `siteWeb` = ?, `telephone` = ?, `courriel` = ?,
                        `actualites` = ?
                    WHERE `identifiant` = ? ;";
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute($envoi);

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }

        if (!$this->trous($donnees['trous'])) {
            return false;
        }

        if (!$this->saveDirigeants()) {
            return false;
        }

        return true;
    }

    public function saveNomImage($image): bool
    {
        // Sauve le nom de l'image du golf
        try {
            $sql = "UPDATE `pitch` SET `image` = ? WHERE `identifiant` = ? ;";
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute([$image, $_SESSION['id_pitch']]);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
        return true;
    }

    protected function espaces($texte): string
    {
        // Remplace les espaces par des espaces insécables
        return $texte;
        $texte = str_replace(" ", "&nbsp;", $texte);
        return $texte;
    }

    protected function trous($trous): bool
    {
        // Enregistrement des trous d'un pitch
        foreach($trous as $key => $value) {
            if ($value != "" && $value != 0) {
                try {
                    $long = (int)$value;
                    $golf = $_SESSION['id_pitch'];
                    $hole = $key + 1;
                    $sql = "UPDATE trous t
                            LEFT JOIN pitch as p
                            ON t.id_golf = p.id
                            SET t.longueur = ?
                            WHERE p.identifiant = ? AND t.trou = ?;";
                    $sth = $this->getConnection()->prepare($sql);
                    $sth->execute([$long, $golf, $hole]);

                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                    return false;
                }
            }
        }
        return true;
    }

    protected  function saveDirigeants(): bool
    {
        // Enregistre les données des dirigeants
        foreach($_SESSION['club']['dirigeants'] as $key => $value) {
            $id = $value['id'] ? $value['id'] : Null;
            if ($value['Nom'] == "") {
                continue;
            } else {
                $nom = $value['Nom'];
            }
        }

        return true;
    }

    public function getLigues($id_ligue = Null): array
    {
        // Récupère la liste des ligues
        try {
            $sql = "SELECT * FROM `ligues`";
            if ($id_ligue != Null) { $sql = $sql . " WHERE id = $id_ligue"; }
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute();
            $results = $sth->fetchall();
            return $results;

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return array();
        }
    }

    public function getProvinces($id_ligue = Null, $id_Province = Null)
    {
        // Récupère la liste des provinces
        try {
            $sql = "SELECT * FROM `provinces` WHERE 1";
            if ($id_ligue != Null) { $sql = $sql . " AND id_ligue = $id_ligue"; }
            if ($id_Province != Null) { $sql = $sql . " AND id = $id_Province"; }
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute();
            $results = $sth->fetchall();
            return $results;

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return array();
        }
    }

    public function getDepartements($id_ligue = Null, $id_Province = Null, $id_departement = Null): array
    {
        // Récupère la liste des départements
        try {
            $sql = "SELECT * FROM `departements` WHERE 1";
            if ($id_Province != Null) { $sql = $sql . " AND id = $id_Province"; }
            if ($id_departement != Null) { $sql = $sql . " AND id = $id_departement"; }
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute();
            $results = $sth->fetchall();
            return $results;

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return array();
        }
    }


    public function getDepartement($id_departement): array
    {
        // Récupère la liste des départements
        try {
            // $sql = "SELECT * FROM `departements` WHERE id = $id_departement";
            $sql = "SELECT d.*, p.* FROM `departements` as d LEFT JOIN
                (SELECT pr.id as idprovince, pr.nom as nom_province,
                        li.id as id_ligue, li.nom as nom_ligue FROM `provinces` as pr
                    LEFT JOIN `ligues` as li ON pr.id_ligue =  li.id) as p
                    ON p.idprovince = d.id_province WHERE d.id = $id_departement";
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute();
            $results = $sth->fetch();
            return $results;

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return array();
        }
    }

    public function sauvePitch(): bool
    {
        // Enregistre un nouveau pitch
        try {
            $sql = "INSERT INTO `pitch`
                (`identifiant`, `nom`, `motDePasse`, `telephone`,
                    `courriel`, `gps`, `siteWeb`, `departement`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY
                UPDATE `nom` = ?, `motDePasse` = ?, `telephone` = ?, `courriel` = ?, `gps` = ?,
                    `siteWeb` = ?, `departement` = ?";
            $envoi = array($_SESSION['newPitch']['code']);
            $envoi[] = $_SESSION['newPitch']['nom'];
            $envoi[] = $_SESSION['newPitch']['mdp'];
            $envoi[] = $_SESSION['newPitch']['telephone'];
            $envoi[] = $_SESSION['newPitch']['courriel'];
            $envoi[] = $_SESSION['newPitch']['gps'];
            $envoi[] = $_SESSION['newPitch']['web'];
            $envoi[] = $_SESSION['newPitch']['departement'];
            $envoi[] = $_SESSION['newPitch']['nom'];
            $envoi[] = $_SESSION['newPitch']['mdp'];
            $envoi[] = $_SESSION['newPitch']['telephone'];
            $envoi[] = $_SESSION['newPitch']['courriel'];
            $envoi[] = $_SESSION['newPitch']['gps'];
            $envoi[] = $_SESSION['newPitch']['web'];
            $envoi[] = $_SESSION['newPitch']['departement'];

            $sth = $this->getConnection()->prepare($sql);
            $sth->execute($envoi);

            return True;

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return False;
        }

    }

    public function getIdDepartement($codeDepartement): int
    {
        try {
            $sql = "SELECT `id` FROM `departements` WHERE `code` = ?";
            $donnees = [$codeDepartement];
            $sth = $this->getConnection()->prepare($sql);
            $sth->execute($donnees);
            $results = $sth->fetch();
            return $results['id'];
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return 0;
        }
    }


}

