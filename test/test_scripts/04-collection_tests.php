<?php
/***************************************************************************************************************************/
/**
    Chameleon Object Abstraction Layer
    
    © Copyright 2018, Little Green Viper Software Development LLC.
    
    This code is proprietary and confidential code, 
    It is NOT to be reused or combined into any application,
    unless done so, specifically under written license from Little Green Viper Software Development LLC.

    Little Green Viper Software Development: https://littlegreenviper.com
*/
require_once(dirname(dirname(__FILE__)).'/functions.php');

function collection_test_relay($in_test_number, $in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $function_name = sprintf('collection_test_%02d', $in_test_number);
    
    $function_name($in_login, $in_hashed_password, $in_password);
}
    
function collection_test_01($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        for ($id = 2; $id < 13; $id++) {
            $st1 = microtime(TRUE);
            $item = $access_instance->get_single_security_record_by_id($id);
            $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
            if (isset($item) && $item) {
                echo('<div class="inner_div">');
                    if ( isset($item) ) {
                        display_record($item);
                    }
                    echo ("<p><em>This took $fetchTime seconds.</em></p>");
                echo('</div>');
            }
        }
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

function collection_test_02($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(2);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(3);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(4);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(5);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(6);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(7);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(8);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(9);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(10);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}
    
function collection_test_03($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place'));
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            $count = count($item_list);
            echo ("<p><em>We got $count items in $fetchTime seconds.</em></p>");
            foreach ($item_list as $item) {
                echo('<div class="inner_div">');
                    if ( isset($item) ) {
                        display_record($item);
                    }
                echo('</div>');
            }
        }
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

ob_start();

    prepare_databases('collection_tests');
    
    echo('<div class="test-wrapper" style="display:table;margin-left:auto;margin-right:auto;text-align:left">');            
        echo('<h1 class="header">COLLECTION TESTS</h1>');
        echo('<div id="collection-tests" class="closed">');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'collection-tests\')">TAKING INVENTORY</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-021" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-021\')">TEST 21: Just List All the Logins.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This will just list the logins we will be working with in the following tests.</p>
                            <?php
                        echo('</div>');
                        collection_test_relay(1, 'admin', '', CO_Config::$god_mode_password);
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-022" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-022\')">TEST 22: Just List All the Collections.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This will just list the collections we will be working with in the following tests.</p>
                            <?php
                        echo('</div>');
                        collection_test_relay(2);
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-023" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-023\')">TEST 23: Just List All the Places.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This will just list the various location objects we will be working with in the following tests.</p>
                            <?php
                        echo('</div>');
                        collection_test_relay(3);
                    echo('</div>');
                echo('</div>');
                
            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>
