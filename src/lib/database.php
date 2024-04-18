<?php

namespace Application\Lib\Database;

class DatabaseConnection
{

    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null)
        {
            $servername = "localhost";
            $username = "pitch_user";
            $password = "@2hZkGnY]H@OsoWe";
            $myDB = "pitchgolf";

            try {
                $this->database = new \PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return $this->database;
    }

    public function toString(): String
    {
        if  ($this->database === null)
        {
            return "Connexion non définie";
        } else {
            return "mysql:host=localhost;dbname=pitchgolf;charset=utf8', 'pitch_user'";
        }
    }

    public function getPitch($idPitch): array
    {
        $sql = "SELECT * FROM pitch WHERE identifiant = ? ";
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute([$idPitch]);
        $result = $sth->fetch();
        return $result;
    }

    public function getTrous($idPitch): array
    {
        $sql = "SELECT t.longueur FROM trous as t LEFT JOIN pitch as p ON t.id_golf = p.id WHERE p.identifiant = ?; " ;
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute([$idPitch]);
        $results = $sth->fetchall();

        return $results;
    }

    public function enregistreDonnees($donnees): bool
    {
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
                $donnees['web'], $_SESSION['id_pitch']];

        try {
            $sql = "UPDATE `pitch`
                    SET `nom` = ?, `gps` = ?, `pitch` = ?, `nbGreen` = ?, `nbDepart` = ?,
                        `greenSynthe` = ?, `departSynthe` = ?, `competition` = ?,
                        `entrainement` = ?, `longTotale` = ?, `zoneEntrainement` = ?,
                        `locationClubs` = ?, `locationSac` = ?, `tarifs` = ?, `horaires` = ?,
                        `restaurant` = ?, `restauRapide` = ?, `horaireRestau` = ?,
                        `acces` = ?, `siteWeb` = ?
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

        return true;
    }

    public function saveNomImage($image): bool
    {
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
        return $texte;
        $texte = str_replace(" ", "&nbsp;", $texte);
        return $texte;
    }

    protected function trous($trous): bool
    {
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

}

