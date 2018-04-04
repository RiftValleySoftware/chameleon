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

function basic_test_relay($in_test_number, $in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $function_name = sprintf('basic_test_%02d', $in_test_number);
    
    $function_name($in_login, $in_hashed_password, $in_password);
}
    
function basic_test_01($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        echo("<h2>The access instance is valid!</h2>");
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(21131);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
                echo ('<h4>Address:</h4>');
                    echo('<div class="inner_div">');
                    $address = $item->geocode_long_lat();
                    foreach ($address as $key => $value) {
                        if (trim($value)) {
                            echo("<p><strong>$key:</strong> <em>$value</em></p>");
                        }
                    }
                echo('</div>');
                $ll = $item->lookup_address();
                echo ("<p><strong>Longitude and Latitude:</strong> <em>(".$ll['longitude'].", ".$ll['latitude'].")</em></p>");
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(11236);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
                echo ('<h4>Address:</h4>');
                    echo('<div class="inner_div">');
                    $address = $item->geocode_long_lat();
                    foreach ($address as $key => $value) {
                        if (trim($value)) {
                            echo("<p><strong>$key:</strong> <em>$value</em></p>");
                        }
                    }
                echo('</div>');
                $ll = $item->lookup_address();
                echo ("<p><strong>Longitude and Latitude:</strong> <em>(".$ll['longitude'].", ".$ll['latitude'].")</em></p>");
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(10872);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
                echo ('<h4>Address:</h4>');
                    echo('<div class="inner_div">');
                    $address = $item->geocode_long_lat();
                    foreach ($address as $key => $value) {
                        if (trim($value)) {
                            echo("<p><strong>$key:</strong> <em>$value</em></p>");
                        }
                    }
                echo('</div>');
                $ll = $item->lookup_address();
                echo ("<p><strong>Longitude and Latitude:</strong> <em>(".$ll['longitude'].", ".$ll['latitude'].")</em></p>");
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(7562);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
                echo ('<h4>Address:</h4>');
                    echo('<div class="inner_div">');
                    $address = $item->geocode_long_lat();
                    foreach ($address as $key => $value) {
                        if (trim($value)) {
                            echo("<p><strong>$key:</strong> <em>$value</em></p>");
                        }
                    }
                echo('</div>');
                $ll = $item->lookup_address();
                echo ("<p><strong>Longitude and Latitude:</strong> <em>(".$ll['longitude'].", ".$ll['latitude'].")</em></p>");
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(1302);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
                echo ('<h4>Address:</h4>');
                    echo('<div class="inner_div">');
                    $address = $item->geocode_long_lat();
                    foreach ($address as $key => $value) {
                        if (trim($value)) {
                            echo("<p><strong>$key:</strong> <em>$value</em></p>");
                        }
                    }
                echo('</div>');
                $ll = $item->lookup_address();
                echo ("<p><strong>Longitude and Latitude:</strong> <em>(".$ll['longitude'].", ".$ll['latitude'].")</em></p>");
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
        $st1 = microtime(TRUE);
        $item = $access_instance->get_single_data_record_by_id(20764);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($item) ) {
                display_record($item);
                echo ('<h4>Address:</h4>');
                    echo('<div class="inner_div">');
                    $address = $item->geocode_long_lat();
                    foreach ($address as $key => $value) {
                        if (trim($value)) {
                            echo("<p><strong>$key:</strong> <em>$value</em></p>");
                        }
                    }
                echo('</div>');
                $ll = $item->lookup_address();
                echo ("<p><strong>Longitude and Latitude:</strong> <em>(".$ll['longitude'].", ".$ll['latitude'].")</em></p>");
            }
            echo ("<p><em>This took $fetchTime seconds.</em></p>");
        echo('</div>');
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}
    
function basic_test_02($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        echo("<h2>The access instance is valid!</h2>");
        $st1 = microtime(TRUE);
        $test_item = $access_instance->generic_search(Array('location' => Array('longitude' => -77.0502, 'latitude' => 38.8893, 'radius' => 50.0)));
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo('<div class="inner_div">');
            if ( isset($test_item) ) {
                if (is_array($test_item)) {
                    if (count($test_item)) {
                        echo("<h4>We got ".count($test_item)." records in $fetchTime seconds.</h4>");
                        foreach ( $test_item as $item ) {
                            display_record($item);
                        }
                    }
                }
            }
        echo('</div>');
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

ob_start();

    prepare_databases('dc_area_tests');
    
    echo('<div class="test-wrapper" style="display:table;margin-left:auto;margin-right:auto;text-align:left">');
        echo('<h1 class="header">BASIC TESTS</h1>');
        echo('<div id="basic-login-tests" class="closed">');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'basic-login-tests\')">READ PLACES</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-011" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-011\')">TEST 11: Test Geocode.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This test will fetch six known records, and will ask the location object to do a geocode and address lookup.</p>
                            <?php
                        echo('</div>');
                        basic_test_relay(1);
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-012" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-012\')">TEST 12: Select a location and radius, and Read The Entries.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This test will dump a subset of the "places" that have been instantiated in the database.</p>
                            <p class="explain">It works by choosing a location in Washington DC, and searching for meetings within a 50Km radius.</p>
                            <?php
                        echo('</div>');
                        basic_test_relay(2);
                    echo('</div>');
                echo('</div>');
                
            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>
