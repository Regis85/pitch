<?php
namespace Application\Lib\Connect;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class ConnectRepository
{
    public DatabaseConnection $connection;

    public function connectUser(): bool
    {
        $this->connection = new DatabaseConnection();
        $this->connection->getPitch($_GET['saisie']);
        $trous = $this->connection->getTrous($_GET['saisie']);
        $this->chargeSession($row, $trous);

        if (!$_SESSION['connecte']) {
            if (isset($_POST['mdp']) && password_verify($_POST['mdp'], $row['motDePasse'])) {
                // Le mot de passe est valide !
                $_SESSION['connecte'] = bin2hex(random_bytes(10));
                return true;
            } else {
                $_SESSION['connecte'] = False;
                return false;
            }
            return false;
        } else {
            return true;
        }
    }

    public function chargeSession($row, $trous): bool
    {
        $_SESSION['club'] = $row;
        $_SESSION['club']['trou'] = array_fill(0,18, "");
        foreach ($trous as $trou => $longueur) {
            $_SESSION['club']['trou'][$trou] = $longueur['longueur'] ;
        }
        return true;
    }


}
