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
    
    $st1 = microtime(TRUE);
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $server_lang = CO_Config::$lang;
        $access_lang = $access_instance->get_lang();
        $login_lang = $access_instance->get_login_item()->get_lang();
        $user_lang = $access_instance->get_user_from_login()->get_lang();
        $fetchTime = sprintf('%01.3f', microtime(TRUE) - $st1);
        echo('<p><strong>Access Object (main) Language: </strong>'.$access_lang.'</p>');
        echo('<p><strong>Server Language: </strong>'.$server_lang.'</p>');
        echo('<p><strong>Login Object Language: </strong>'.$login_lang.'</p>');
        echo('<p><strong>User Object Language: </strong>'.$user_lang.'</p>');
        echo('<p>The test took '.$fetchTime.' seconds.</p>');
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}
    
function lang_test_02($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $st1 = microtime(TRUE);
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $place_instance = $access_instance->get_single_data_record_by_id(5);
        $place_lang = $place_instance->get_lang();
        $server_lang = CO_Config::$lang;
        $access_lang = $access_instance->get_lang();
        $login_lang = $access_instance->get_login_item()->get_lang();
        $user_lang = $access_instance->get_user_from_login()->get_lang();
        $fetchTime = sprintf('%01.3f', microtime(TRUE) - $st1);
        echo('<p><strong>Place Object Language: </strong>'.$place_lang.'</p>');
        echo('<p><strong>Access Object Language: </strong>'.$access_lang.'</p>');
        echo('<p><strong>Server Language: </strong>'.$server_lang.'<em> (It should use this one)</em></p>');
        echo('<p><strong>Login Object Language: </strong>'.$login_lang.'</p>');
        echo('<p><strong>User Object Language: </strong>'.$user_lang.'</p>');
        echo('<p>The test took '.$fetchTime.' seconds.</p>');
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}
    
function lang_test_03($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $st1 = microtime(TRUE);
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $place_instance = $access_instance->get_single_data_record_by_id(6);
        $place_lang = $place_instance->get_lang();
        $server_lang = CO_Config::$lang;
        $access_lang = $access_instance->get_lang();
        $login_lang = $access_instance->get_login_item()->get_lang();
        $user_lang = $access_instance->get_user_from_login()->get_lang();
        $fetchTime = sprintf('%01.3f', microtime(TRUE) - $st1);
        echo('<p><strong>Place Object Language: </strong>'.$place_lang.'</p>');
        echo('<p><strong>Access Object Language: </strong>'.$access_lang.'</p>');
        echo('<p><strong>Server Language: </strong>'.$server_lang.'</p>');
        echo('<p><strong>Login Object Language: </strong>'.$login_lang.'</p>');
        echo('<p><strong>User Object Language: </strong>'.$user_lang.'</p>');
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
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'lang-tests\')">PRECEDENCE TESTS</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-045" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-045\')">TEST 45: Precedence Test 1</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we login with a user that has \'sv\' set as the user lang, \'fr\' set as the login lang, and \'en\' set as the server lang. Let\'s see which one take precedence (It should be the user one).</p>');
                        echo('</div>');
                        lang_test_relay(1, 'norm', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-046" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-046\')">TEST 46: Precedence Test 2</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we login with a user that has no user lang, \'fr\' set as the login lang, and \'en\' set as the server lang. Let\'s see which one take precedence (It should be the login one, and the user object should use the login lang).</p>');
                        echo('</div>');
                        lang_test_relay(1, 'bob', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-047" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-047\')">TEST 47: Precedence Test 3</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we login with a user that has no user lang, no login lang, and \'en\' set as the server lang. Let\'s see which one take precedence (It should be the server one, and the user and login objects should both use the server lang).</p>');
                        echo('</div>');
                        lang_test_relay(1, 'cobra', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');

            echo('</div>');
        echo('</div>');
            
        echo('<div id="misc-tests" class="closed">');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'misc-tests\')">MISCELLANEOUS TESTS</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-048" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-048\')">TEST 48: Default Test</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we load a standard place record with no language indicated. It should come up with the server language (\'en\').</p>');
                        echo('</div>');
                        lang_test_relay(2, 'norm', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-049" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-049\')">TEST 49: Explicit Set Test</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we load a standard place record with a setting for Italian (\'it\'). It should display \'it\'.</p>');
                        echo('</div>');
                        lang_test_relay(3, 'norm', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');

            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>