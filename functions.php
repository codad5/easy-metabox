<?php

require_once __DIR__ . '/includes/cean-class-autoloader.php';
require_once __DIR__ .'/plugin-update-checker/plugin-update-checker.php';

use CeanWP\Controllers\Settings;
use CeanWP\Core\CeanWP;

class CeanWP_Functions extends CeanWP
{
    function launch(): void
    {
        parent::start();
    }

    function activate_auto_updater(): void
    {
        // check if class exists
        $accessToken = Settings::get('github_personal_access_token');
        if (!class_exists('Puc_v4_Factory') || empty($accessToken)) {
            return;
        }
        $updateChecker = Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/Fusion-WordPress-App/CEAN',
            get_template_directory() . '/functions.php',
            'cean-wp-theme'
        );
        $updateChecker->setBranch('master');
        $updateChecker->setAuthentication($accessToken);
    }

}

$ceanwp = new CeanWP_Functions();
$ceanwp->launch();