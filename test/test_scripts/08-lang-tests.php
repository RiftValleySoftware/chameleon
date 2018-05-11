<?php
/***************************************************************************************************************************/
/**
    CHAMELEON Object Abstraction Layer
    
    © Copyright 2018, Little Green Viper Software Development LLC.
    
    This code is proprietary and confidential code, 
    It is NOT to be reused or combined into any application,
    unless done so, specifically under written license from Little Green Viper Software Development LLC.

    Little Green Viper Software Development: https://littlegreenviper.com
*/

if ( !defined('LGV_CONFIG_CATCHER') ) {
    define('LGV_CONFIG_CATCHER', 1);
}

$config_file_path = dirname(__FILE__).'/../config/s_config.class.php';

require_once($config_file_path);
require_once(dirname(dirname(__FILE__)).'/functions.php');

function lang_test_relay($in_test_number, $in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $function_name = sprintf('lang_test_%02d', $in_test_number);
    
    $function_name($in_login, $in_hashed_password, $in_password);
}
    
function lang_test_01($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $fetchTime = sprintf('%01.3f', microtime(TRUE) - $st1);
        echo('<p>The test took '.$fetchTime.' seconds.</p>');
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

ob_start();

    prepare_databases('lang_tests');
    
    echo('<div class="test-wrapper" style="display:table;margin-left:auto;margin-right:auto;text-align:left">');            
        echo('<h1 class="header">LANGUAGE INDICATOR TESTS</h1>');

        echo('<div id="lang-tests" class="closed">');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'lang-tests\')">BASIC TESTS</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-045" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-045\')">TEST 45:</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain"></p>');
                        echo('</div>');
                        lang_test_relay(1, 'norm', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');

            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>
