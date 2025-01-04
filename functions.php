<?php

include_once __DIR__ . '/includes/cean-class-autoloader.php';

use CeanWP\Core\CeanWP;

class CeanWP_Functions
{
    function launch(): void
    {
        CeanWP::start();
    }

    static function get_distributors_list(): array
    {
        return CeanWP::get_distributors_list();
    }

    static function get_partners_list(): array
    {
        return CeanWP::get_partners_list();
    }
}


$ceanwp = new CeanWP_Functions();
$ceanwp->launch();