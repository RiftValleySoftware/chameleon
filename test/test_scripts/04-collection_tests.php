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
set_time_limit ( 120 );

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
        for ($id = 2; $id < 14; $id++) {
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
        for ($id = 2; $id < 12; $id++) {
            $st1 = microtime(TRUE);
            $item = $access_instance->get_single_data_record_by_id($id);
            $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
            echo('<div class="inner_div">');
                if ( isset($item) ) {
                    display_record($item);
                }
                echo ("<p><em>This took $fetchTime seconds.</em></p>");
            echo('</div>');
        }
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
        $item = $access_instance->get_single_data_record_by_id($id);
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
    
function collection_test_display($row_id, $tag, $in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $collection_item = $access_instance->get_single_data_record_by_id($row_id);
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place', 'tags' => Array('', '', '', '', '', $tag)));
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            $count = count($item_list);
            $success_count = 0;
            $fail_count = 0;
            echo ("<p><em>We got $count items in $fetchTime seconds.</em></p>");
            foreach ($item_list as $item) {
                if ($collection_item->appendElement($item)) {
                    $success_count++;
                } else {
                    echo("<h3 style=\"color:red;font-weight:bold\">Unable to add item ".$item->id()."!</h3>");
                    $fail_count++;
                }
            }
            
            if ($success_count == count($item_list)) {
                echo("<h3 style=\"color:green;font-weight:bold\">We successfully added all $success_count $tag items!</h3>");
                hierarchicalDisplayRecord($collection_item, 0, NULL);
            } else {
                echo("<h3 style=\"color:red;font-weight:bold\">We failed to add all the $tag items! There were $fail_count failures!</h3>");
            }
        }
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}
    
function collection_test_04($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    collection_test_display(2, 'DC', $in_login, $in_hashed_password, $in_password);
}
    
function collection_test_05($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    collection_test_display(3, 'VA', $in_login, $in_hashed_password, $in_password);
}
    
function collection_test_06($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    collection_test_display(4, 'MD', $in_login, $in_hashed_password, $in_password);
}
 
function collection_test_07($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    collection_test_display(5, 'WV', $in_login, $in_hashed_password, $in_password);
}
 
function collection_test_08($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    collection_test_display(6, 'DE', $in_login, $in_hashed_password, $in_password);
}
    
function collection_test_09($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);

        $dc_collection_item = $access_instance->get_single_data_record_by_id(2);
        $va_collection_item = $access_instance->get_single_data_record_by_id(3);
        $md_collection_item = $access_instance->get_single_data_record_by_id(4);
        $wv_collection_item = $access_instance->get_single_data_record_by_id(5);
        $de_collection_item = $access_instance->get_single_data_record_by_id(6);
                        
        $main_collection_item->appendElement($dc_collection_item);

        $main_collection_item->appendElements(Array($de_collection_item, $md_collection_item, $va_collection_item, $wv_collection_item));
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo ("<p><em>The test took $fetchTime seconds.</em></p>");
        
        hierarchicalDisplayRecord($main_collection_item, 0, NULL);
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}
    
function collection_test_10($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);

        $dc_collection_item = $access_instance->get_single_data_record_by_id(2);
        $va_collection_item = $access_instance->get_single_data_record_by_id(3);
        $md_collection_item = $access_instance->get_single_data_record_by_id(4);
        $wv_collection_item = $access_instance->get_single_data_record_by_id(5);
        $de_collection_item = $access_instance->get_single_data_record_by_id(6);
                        
        $va_collection_item->appendElement($dc_collection_item);

        $md_collection_item->appendElement($va_collection_item);

        $wv_collection_item->appendElement($md_collection_item);

        $de_collection_item->appendElement($wv_collection_item);
        
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place', 'tags' => Array('', '', '', '', '', 'DC')));
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            if (!$dc_collection_item->appendElements($item_list)) {
                echo("<h3 style=\"color:red;font-weight:bold\">Unable to add items!</h3>");
                $item_list = NULL;
            }
        }
        
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            $main_collection_item->appendElement($de_collection_item);
        
            $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
            echo ("<p><em>The test took $fetchTime seconds.</em></p>");
    
            hierarchicalDisplayRecord($main_collection_item, 0, NULL);
        }
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}
    
function collection_test_11($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo ("<p><em>The test took $fetchTime seconds.</em></p>");
    
        hierarchicalDisplayRecord($main_collection_item, 0, NULL);
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

function collection_test_12($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place', 'tags' => Array('', '', '', '', '', 'DC')));
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            echo("<h3>Trying to add a single element that is already deep in the hierarchy.</h3>");
            if ($main_collection_item->appendElement($item_list[intval(count($item_list) / 2)])) {
                echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE SUCCEEDED!</h3>");
                $item_list = NULL;
            } else {
                echo("<h3>That worked.</h3>");
                echo("<h3>Trying to add a whole bunch of elements that are already deep in the hierarchy.</h3>");
                if ($main_collection_item->appendElements(array_splice($item_list, 6, 53))) {
                    echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE SUCCEEDED!</h3>");
                    $item_list = NULL;
                } else {
                    echo("<h3>That worked too!</h3>");
                }
            }
        }
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo ("<p><em>The test took $fetchTime seconds.</em></p>");
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

function collection_test_13($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place', 'tags' => Array('', '', '', '', '', 'WV')));
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            echo("<h3>Trying to add a single element that is not in the hierarchy.</h3>");
            if (!$main_collection_item->appendElement($item_list[2])) {
                echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE FAILED!</h3>");
                $item_list = NULL;
            } else {
                echo("<h3>That worked.</h3>");
                echo("<h3>Trying to add a whole bunch of elements that are not in the hierarchy.</h3>");
                if (!$main_collection_item->appendElements(array_splice($item_list, 3, 22))) {
                    echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE FAILED!</h3>");
                    $item_list = NULL;
                } else {
                    echo("<h3>That worked too!</h3>");
                }
            }
        }
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo ("<p><em>The test took $fetchTime seconds.</em></p>");
    
        hierarchicalDisplayRecord($main_collection_item, 0, NULL);
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

function collection_test_14($in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
    $access_instance = NULL;
    
    if ( !defined('LGV_ACCESS_CATCHER') ) {
        define('LGV_ACCESS_CATCHER', 1);
    }
    
    require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
    
    $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
    
    if ($access_instance->valid) {
        $st1 = microtime(TRUE);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);
        $second_collection_item = $access_instance->get_single_data_record_by_id(2);
        echo("<h3>Trying to add a collection element that is already in the hierarchy.</h3>");
        if ($main_collection_item->appendElement($second_collection_item)) {
            echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE SUCCEEDED!</h3>");
            $item_list = NULL;
        } else {
            echo("<h3>That worked.</h3>");
            echo("<h3>Creating a new Collection Object, and Adding Elements in the Hierarchy to It.</h3>");
            $new_collection = $access_instance->make_new_blank_record('CO_US_Place_Collection');
            if ($new_collection) {
                hierarchicalDisplayRecord($new_collection, 0, NULL);
                echo("<h4>New Collection Created. We won't bother populating its fields; we'll just add some data.</h4>");
                $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place', 'tags' => Array('', '', '', '', '', 'VA')));
                if (isset($item_list) && is_array($item_list) && count($item_list)) {
                    $count = count($item_list);
                    echo ("<p><em>We got $count items.</em></p>");
                    echo("<h4>Adding a few VA meetings to it (These are not in the hierarchy).</h4>");
                    if (!$new_collection->appendElements($item_list)) {
                        echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE FAILED!</h3>");
                    } else {
                        echo("<h4>Adding the \"poison pill\" item (A DC meeting).</h4>");
                        $bad_item = $access_instance->get_single_data_record_by_id(691); 

                        if (!$new_collection->appendElement($bad_item)) {
                            echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE FAILED!</h3>");
                        } else {
                            echo("<h4>OK. Now we try to add this to the main hierarchy. It should fail.</h4>");
                            if ($main_collection_item->appendElement($new_collection)) {
                                echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE SUCCEEDED!</h3>");
                                $item_list = NULL;
                            } else {
                                echo("<h3>That worked! Woo-Hoo!</h3>");
                            }
                        }
                    }
                }
            }
        }
        $fetchTime = sprintf('%01.4f', microtime(TRUE) - $st1);
        echo ("<p><em>The test took $fetchTime seconds.</em></p>");
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
    }
}

ob_start();

    echo('<div class="test-wrapper" style="display:table;margin-left:auto;margin-right:auto;text-align:left">');            
        echo('<h1 class="header">COLLECTION TESTS</h1>');
    
        echo('<div id="taking-inventory" class="closed">');
            prepare_databases('collection_tests');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'taking-inventory\')">TAKING INVENTORY</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-021" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-021\')">TEST 21: Just List All the Logins.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">This will just list the logins we will be working with in the following tests.</p>');
                        echo('</div>');
                        collection_test_relay(1, 'admin', '', CO_Config::$god_mode_password);
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-022" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-022\')">TEST 22: Just List All the Collections.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">This will just list the collections we will be working with in the following tests.</p>');
                        echo('</div>');
                        collection_test_relay(2);
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-023" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-023\')">TEST 23: Just List All the Places.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">This will just list the various location objects we will be working with in the following tests.</p>');
                        echo('</div>');
                        collection_test_relay(3);
                    echo('</div>');
                echo('</div>');
                
            echo('</div>');
        echo('</div>');
    
        echo('<div id="collection-setup-tests" class="closed">');
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'collection-setup-tests\')">SETTING UP THE COLLECTIONS</a></h2>');
            echo('<div class="container">');
        
                echo('<div id="test-024" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-024\')">TEST 24: Set up the DC Collection.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the DC Admin, open the DC Collection, and try to add the DC meetings.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(4, 'DCAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
        
                echo('<div id="test-025" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-025\')">TEST 25: Set up the VA Collection.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Virginia Admin, open the VA Collection, and try to add the VA meetings.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(5, 'VAAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
        
                echo('<div id="test-026" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-026\')">TEST 26: Set up the MD Collection.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Maryland Admin, open the MD Collection, and try to add the MD meetings.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(6, 'MDAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
        
                echo('<div id="test-027" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-027\')">TEST 27: Fail to set up the WV Collection.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Maryland Admin, but open the West Virginia Collection, and try to add the WV meetings.</p>');
                            echo('<p class="explain">We expect this to fail. We can see all the items, but we don\'t have write privileges on the collection, so we can\'t add stuff to it.</p>');
                        echo('</div>');
                        collection_test_relay(7, 'MDAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
        
                echo('<div id="test-028" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-028\')">TEST 28: Set up the WV Collection.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the West Virginia Admin, open the WV Collection, and try to add the WV meetings.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(7, 'WVAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
        
                echo('<div id="test-029" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-029\')">TEST 29: Set up the DE Collection.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Delaware Admin, open the DE Collection, and try to add the DE meetings.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(8, 'DEAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
        
                echo('<div id="test-030" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-030\')">TEST 30: Create a "Collection of Collections."</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the "Main" Admin, load an empty collection, then add every other collection to it.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(9, 'AllAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');

            echo('</div>');
        echo('</div>');

        echo('<div id="more-cowbell" class="closed">');
            prepare_databases('collection_tests');
    
            echo('<h2 class="header"><a href="javascript:toggle_main_state(\'more-cowbell\')">MORE COWBELL</a></h2>');
            echo('<div class="container">');
            
                echo('<div id="test-031" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-031\')">TEST 31: "Deep Dive" Test</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Main Admin, and nest the collections, so they will be a deep hierarchy.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(10, 'AllAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-032" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-032\')">TEST 32: Reload "Deep Dive" Test</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Main Admin, and reload the root collection we just loaded up.</p>');
                            echo('<p class="explain">We expect this to succeed, and look exactly like the previous test.</p>');
                        echo('</div>');
                        collection_test_relay(11, 'AllAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-033" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-033\')">TEST 33: Try to Insert Items Already in the Hierarchy.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Main Admin, try to add elements that are already in the hierarchy.</p>');
                            echo('<p class="explain">We expect this to fail.</p>');
                        echo('</div>');
                        collection_test_relay(12, 'AllAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-034" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-034\')">TEST 34: Try to Insert Items Not in the Hierarchy.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Main Admin, try to add elements that are not in the hierarchy.</p>');
                            echo('<p class="explain">We expect this to succeed.</p>');
                        echo('</div>');
                        collection_test_relay(13, 'AllAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
            
                echo('<div id="test-035" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-035\')">TEST 35: Try to Insert A Collection Already in the Hierarchy.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">In this test, we log in as the Main Admin, try to add a collection that is already in the hierarchy.</p>');
                            echo('<p class="explain">We expect this to fail.</p>');
                        echo('</div>');
                        collection_test_relay(14, 'AllAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');

            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>