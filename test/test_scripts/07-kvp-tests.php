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

function kvp_test_relay($in_test_number, $in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $function_name = sprintf('kvp_test_%02d', $in_test_number);
    
    $function_name($in_login, $in_hashed_password, $in_password);
}
    
function kvp_test_01($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $test_subject = $access_instance->make_new_blank_record('CO_KeyValue');
        
        if (isset($test_subject) && $test_subject ) {
            $success = $test_subject->set_key('Rick Moranis', 'Sigorney Weaver');
            if ($success) {
                $the_gatekeeper = $access_instance->get_value_for_key('Rick Moranis');
                
                if (isset($the_gatekeeper)) {
                    if ($the_gatekeeper == 'Sigorney Weaver') {
                        $access_instance = NULL;
                        $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
                        if ($access_instance->valid) {
                            $the_gatekeeper = $access_instance->get_value_for_key('Rick Moranis');
                        
                            if (isset($the_gatekeeper)) {
                                if ($the_gatekeeper == 'Sigorney Weaver') {
                                    echo('<h3>WOOT! Tests Pass!</h3>');
                                } else {
                                    echo("<h2 style=\"color:red;font-weight:bold\">The Keymaster lost his girlfriend!</h2>");
                                }
                            } else {
                                echo("<h2 style=\"color:red;font-weight:bold\">The Keymaster is lost!</h2>");
                                echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
                            }
                        } else {
                            echo("<h2 style=\"color:red;font-weight:bold\">There was an error with accessing the Keymaster!</h2>");
                            echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
                        }
                    } else {
                        echo("<h2 style=\"color:red;font-weight:bold\">The Keymaster has no girlfriend!</h2>");
                    }
                } else {
                    echo("<h2 style=\"color:red;font-weight:bold\">We could not find the Keymaster!</h2>");
                }
            } else {
                echo("<h2 style=\"color:red;font-weight:bold\">The Keymaster was unable to perform!</h2>");
                echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$test_subject->error->error_code.') '.$test_subject->error->error_name.' ('.$test_subject->error->error_description.')</p>');
            }
        } else {
            echo("<h2 style=\"color:red;font-weight:bold\">The Keymaster was eaten by Zool!</h2>");
            echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
        }
        
        $fetchTime = sprintf('%01.3f', microtime(TRUE) - $st1);
        echo('<p>The test took '.$fetchTime.' seconds.</p>');
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

ob_start();

    prepare_databases('kvp_tests');
    
    echo('<div class="test-wrapper" style="display:table;margin-left:auto;margin-right:auto;text-align:left">');            
        echo('<h1 class="header">KEY/VALUE TESTS</h1>');

        echo('<div id="owner-tests" class="closed">');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'owner-tests\')">SIMPLE STORAGE TESTS</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-041" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-041\')">TEST 41: Store and retrieve small data -No Login</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">We start by not logging in. We expect this to fail.</p>');
                        echo('</div>');
                        kvp_test_relay(1);
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-042" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-042\')">TEST 42: Store and retrieve small data -God Login</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">Now we login with the "God" login. This should work.</p>');
                        echo('</div>');
                        kvp_test_relay(1, 'admin', '', CO_Config::$god_mode_password);
                    echo('</div>');
                echo('</div>');

            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>
