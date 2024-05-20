<?php
namespace Application\Lib\ChangeMdp;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;


class ChangeMdp
{
    public DatabaseConnection $connection;

    public function execute(): bool
    {
        // On affiche la page de saisie
        require('templates/change_mdp.php');

        return True;

    }

    public function verifieMdp(): bool
    {
        if ($_POST['soumet'] === "annule") {
            $_SESSION['message']['class'] = "rouge";
            $_SESSION['message']['texte'] = "Annulation de la modification du mot de passe";
            return False;
        }

        // On vérifie que le nouveau mot de passe n'est pas vide
        if ($_POST['nouveauMdp'] =='') {
            $_SESSION['message']['class'] = "rouge gras grand";
            $_SESSION['message']['texte'] = "Erreur de saisie du mot de passe,<br>le nouveau mot de passe ne peut pas être vide";
            return True;
        }

        // Vérifier $_SESSION[connecte] =  $_POST[connecte];
        if ($_SESSION['connecte'] !== $_POST['connecte']) {
            die();
        }

        // Vérifier que l'ancien mot de passe correspond à l'entrée
        if (!password_verify($_POST['ancienMdp'], $_SESSION['club']['motDePasse'])) {
            $_SESSION['message']['class'] = "rouge gras grand";
            $_SESSION['message']['texte'] = "Erreur de saisie du mot de passe,<br>le nouveau mot de passe n'a pas été enregistré";
            return True;
        }

        // Vérifier que les 2 nouveaux mots de passe sont identiques
        if ($_POST['nouveauMdp'] !== $_POST['verifMdp']) {
            $_SESSION['message']['class'] = "rouge gras grand";
            $texte = "Erreur de saisie du nouveau mot de passe,<br>";
            $texte = $texte . " les 2 saisies ne sont pas identiques.";
            $_SESSION['message']['texte'] = $texte;
            return True;
        }

        // On enregistre le nouveau mot de passe
        $this->connection = new DatabaseConnection();
        if ($this->connection->enregistreMdp($_POST['nouveauMdp'], $_SESSION['club']['identifiant'])) {
            $_SESSION['message']['class'] = "vert";
            $texte = "Nouveau mot de passe enregistré";
            $_SESSION['message']['texte'] = $texte;
            return True;
        }

        exit('Erreur fatale lors du changement de mot de passe');
    }

}
