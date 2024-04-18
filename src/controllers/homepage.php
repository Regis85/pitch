<?php

namespace Application\Controllers\Homepage;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Homepage
{

    public function execute()
    {
        /*===== On récupère les données du pitch =====*/
        // print_r($_SESSION);
        $pitch = (new DatabaseConnection())->getPitch($_SESSION['id_pitch']);
        $con = new DatabaseConnection();
        $trous = $con->getTrous($_SESSION['id_pitch']);

        /*===== On affiche les données =====*/
        require_once('templates/homepage.php');

    }

}
