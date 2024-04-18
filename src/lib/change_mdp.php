<?php
namespace Application\Lib\ChangeMdp;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;


class ChangeMdp
{
    public DatabaseConnection $connection;

    public function execute(): bool
    {
        echo "<br>Enregistrement du mot de passe<br>";
        return True;

    }

}
