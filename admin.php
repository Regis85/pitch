<?php

require_once('src/controllers/adminpage.php');

use Application\Controllers\Adminpage\Adminpage;
// On démarre une nouvelle session
session_start();

$adminpage = new Adminpage();
$adminpage->execute();

