<?php

namespace Application\lib\Session;

class Session
{
    function getConnecte(): bool
    {

        if (isset($_SESSION['identifiant']))
        {
            $connecte = true;
        } else {
            $connecte = false;
        }

        return $connecte;
    }

}
