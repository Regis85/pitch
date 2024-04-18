<?php

namespace Application\Models\Pitch;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class PitchRepository
{
    public DatabaseConnection $connection;

    public function getPitch(int $idPitch)
    {
        $result=1;
        /*
        try
        {
            $sth = $this->connection->getConnection()->prepare(
                'SELECT * FROM pitch WHERE identifiant = ? '
            );
            $sth->execute([$idPitch]);
            $result = $sth->fetch();
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            require('templates/error.php');
        }
        */
        return $result;
    }

}
