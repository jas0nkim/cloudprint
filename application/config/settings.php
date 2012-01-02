<?php

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     staging
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
    $host = $_SERVER['HTTP_HOST'];
    if (stripos($host, "adminpanel.freeprint.dev") === 0) {
        define('ENVIRONMENT', 'development');
    } else {
        define('ENVIRONMENT', 'production');
    }

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

    if (defined('ENVIRONMENT')) {
        switch (ENVIRONMENT)
        {
            case 'development':
                $env_dependent_path = '/home/dev/www';
                error_reporting(E_ALL);
            break;

            case 'production':
                $env_dependent_path = '';
                error_reporting(0);
            break;

            default:
                $env_dependent_path = '';
                exit('The application environment is not set correctly.');
        }
    } else {
        exit("Your 'ENVIRONMENT' is not defined. Please check your environment.");
    }

    // The path to the "env_dependent" folder
    if (is_dir($env_dependent_path)) {
        define('ENV_DEPENDENT_PATH', $env_dependent_path.'/');
    } else {
        exit("Your environment dependent path does not appear to be set correctly");
    }

    require_once dirname(__FILE__).'/'.ENVIRONMENT.'/settings.php';


/* End of file settings.php */
/* Location: ./application/config/settings.php */