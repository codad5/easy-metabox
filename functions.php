<?php

include_once __DIR__ . '/includes/cean-class-autoloader.php';

use CeanWP\Core\CeanWP;
use CeanWP\Models\Cean_WP_Top_Grossing_Movies;
use CeanWP\Models\CeanWP_Contact_Form;

class CeanWP_Functions extends CeanWP
{
    function launch(): void
    {
        parent::start();
    }

}

$ceanwp = new CeanWP_Functions();
$ceanwp->launch();