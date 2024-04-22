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

        // On récupère les données du pitch
        $donnees = $this->connection->getPitch($_GET['saisie']);

        $trous = $this->connection->getTrous($_GET['saisie']);
        $this->chargeSession($donnees, $trous);

        if (!isset($_SESSION['connecte']) or !$_SESSION['connecte'])
        {
            if (isset($_POST['mdp']) && password_verify($_POST['mdp'], $donnees['motDePasse'])) {
                // Le mot de passe est valide, on crée un identifiant unique provisoire
                $_SESSION['connecte'] = bin2hex(random_bytes(10));
                return true;
            } else {
                // Erreur de mot de passe, on ferme la connexion pour interdire les modifications
                $_SESSION['connecte'] = False;
                return false;
            }
            // On arrive sans être connecter et sans mot de passe, on interdit les modifications
            return false;
        } else {
            return true;
        }
    }

    public function chargeSession($donnees, $trous): bool
    {
        // On charge les données du pitch dans la session
        $_SESSION['club'] = $donnees;
        $_SESSION['club']['trou'] = array_fill(0,18, "");
        foreach ($trous as $trou => $longueur) {
            $_SESSION['club']['trou'][$trou] = $longueur['longueur'] ;
        }
        return true;
    }


}
