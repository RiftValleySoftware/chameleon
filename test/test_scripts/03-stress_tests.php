<?php
/***************************************************************************************************************************/
/**
    CHAMELEON Object Abstraction Layer
    
    © Copyright 2018, The Great Rift Valley Software Company
    
    LICENSE:
    
    MIT License
    
    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
    files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
    modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
    Software is furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
    OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
    IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
    CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

    The Great Rift Valley Software Company: https://riftvalleysoftware.com
*/
require_once(dirname(dirname(__FILE__)).'/functions.php');

function stress_test_relay($in_test_number, $in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $function_name = sprintf('stress_test_%02d', $in_test_number);
    
    $function_name($in_login, $in_hashed_password, $in_password);
}
    
function stress_test_01($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        echo("<h2>The access instance is valid!</h2>");
        
        $st1 = microtime(true);
        $test_item = $access_instance->generic_search(Array('location' => Array('longitude' => -115.2435726, 'latitude' => 36.1356661, 'radius' => 50.0)));
        $fetchTime = sprintf('%01.3f', microtime(true) - $st1);
        echo('<div class="inner_div">');
            if ( isset($test_item) ) {
                if (is_array($test_item)) {
                    if (count($test_item)) {
                        echo("<h4>We got ".count($test_item)." records in $fetchTime seconds.</h4>");
                        $count = 0;
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
    
function stress_test_02($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        echo("<h2>The access instance is valid!</h2>");
        
        $st1 = microtime(true);
        $test_item = $access_instance->generic_search(Array('location' => Array('longitude' => -78.6, 'latitude' => 38.3,  'radius' => 50.0)));
        $fetchTime = sprintf('%01.3f', microtime(true) - $st1);
        echo('<div class="inner_div">');
            if ( isset($test_item) ) {
                if (is_array($test_item)) {
                    if (count($test_item)) {
                        echo("<h4>We got ".count($test_item)." records in $fetchTime seconds.</h4>");
                        $count = 0;
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
    
function stress_test_03($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        echo("<h2>The access instance is valid!</h2>");
        
        $st1 = microtime(true);
        $test_item = $access_instance->generic_search(Array('location' => Array('longitude' => -6.2603, 'latitude' => 53.3498,  'radius' => 50.0)));
        $fetchTime = sprintf('%01.3f', microtime(true) - $st1);
        echo('<div class="inner_div">');
            if ( isset($test_item) ) {
                if (is_array($test_item)) {
                    if (count($test_item)) {
                        echo("<h4>We got ".count($test_item)." records in $fetchTime seconds.</h4>");
                        $count = 0;
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
    
function stress_test_04($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        echo("<h2>The access instance is valid!</h2>");
        
        $st1 = microtime(true);
        $test_item = $access_instance->generic_search(Array('location' => Array('longitude' => 151.2093, 'latitude' => -33.8688,  'radius' => 50.0)));
        $fetchTime = sprintf('%01.3f', microtime(true) - $st1);
        echo('<div class="inner_div">');
            if ( isset($test_item) ) {
                if (is_array($test_item)) {
                    if (count($test_item)) {
                        echo("<h4>We got ".count($test_item)." records in $fetchTime seconds.</h4>");
                        $count = 0;
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

    prepare_databases('stress_tests');
    
    echo('<div class="test-wrapper" style="display:table;margin-left:auto;margin-right:auto;text-align:left">');
        echo('<h1 class="header">STRESS TESTS</h1>');
        echo('<div id="stress-login-tests" class="closed">');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'stress-login-tests\')">READ PLACES</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-017" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-017\')">TEST 17: Log In as "Tertiary", and Read The Entries for the Las Vegas Area.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This test will dump a subset of the "places" that have been instantiated in the database.</p>
                            <?php
                        echo('</div>');
                        stress_test_relay(1, 'tertiary', 'CodYOzPtwxb4A');
                        $start = microtime(true);
                        echo('<h5>The test took '. sprintf('%01.3f', microtime(true) - $start) . ' seconds.</h5>');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-018" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-018\')">TEST 18: Check the DC Area with No Login</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This test will dump a subset of the "places" that have been instantiated in the database.</p>
                            <?php
                        echo('</div>');
                        stress_test_relay(2);
                        $start = microtime(true);
                        echo('<h5>The test took '. sprintf('%01.3f', microtime(true) - $start) . ' seconds.</h5>');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-019" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-019\')">TEST 19: Check the Dublin, Ireland Area with No Login</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This test will dump a subset of the "places" that have been instantiated in the database.</p>
                            <?php
                        echo('</div>');
                        stress_test_relay(3);
                        $start = microtime(true);
                        echo('<h5>The test took '. sprintf('%01.3f', microtime(true) - $start) . ' seconds.</h5>');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-020" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-020\')">TEST 20: Check the Sydney, Australia Area with No Login</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            ?>
                            <p class="explain">This test will dump a subset of the "places" that have been instantiated in the database.</p>
                            <?php
                        echo('</div>');
                        stress_test_relay(4);
                        $start = microtime(true);
                        echo('<h5>The test took '. sprintf('%01.3f', microtime(true) - $start) . ' seconds.</h5>');
                    echo('</div>');
                echo('</div>');
                
            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>
