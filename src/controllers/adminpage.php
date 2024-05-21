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

        /*===== On affiche les données =====*/
        require_once('templates/adminpage.php');

    }

}
