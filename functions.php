<?php

include_once __DIR__ . '/includes/cean-class-autoloader.php';

use CeanWP\Core\CeanWP;
use CeanWP\Models\Cean_WP_Top_Grossing_Movies;

class CeanWP_Functions extends CeanWP
{
    function launch(): void
    {
        CeanWP::start();
    }

    static function get_all_time_top_grossing_movies(): array
    {
        // getting all time grossing movies
        return Cean_WP_Top_Grossing_Movies::get_top_grossing_movies();
    }

}

$ceanwp = new CeanWP_Functions();
$ceanwp->launch();