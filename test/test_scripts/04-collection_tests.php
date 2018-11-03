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
set_time_limit ( 300 );

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
            $st1 = microtime(true);
            $item = $access_instance->get_single_security_record_by_id($id);
            $fetchTime = sprintf('%01.4f', microtime(true) - $st1);
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
            $st1 = microtime(true);
            $item = $access_instance->get_single_data_record_by_id($id);
            $fetchTime = sprintf('%01.4f', microtime(true) - $st1);
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
        $st1 = microtime(true);
        $st1 = microtime(true);
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place'));
        $fetchTime = sprintf('%01.4f', microtime(true) - $st1);
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            $count = count($item_list);
            echo ("<p><em>We got $count items in $fetchTime seconds.</em></p>");
            foreach ($item_list as $item) {
                display_record($item);
            }
        }
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
        $st1 = microtime(true);
        $collection_item = $access_instance->get_single_data_record_by_id($row_id);
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place', 'tags' => Array(NULL, NULL, NULL, NULL, NULL, $tag)));
        $fetchTime = sprintf('%01.4f', microtime(true) - $st1);
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
        
                $hierarchy = $collection_item->getHierarchy();
                $modifier = $row_id.'_'.$tag;
                display_raw_hierarchy($hierarchy, $modifier);
                
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
        $st1 = microtime(true);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);

        $dc_collection_item = $access_instance->get_single_data_record_by_id(2);
        $va_collection_item = $access_instance->get_single_data_record_by_id(3);
        $md_collection_item = $access_instance->get_single_data_record_by_id(4);
        $wv_collection_item = $access_instance->get_single_data_record_by_id(5);
        $de_collection_item = $access_instance->get_single_data_record_by_id(6);
                        
        $main_collection_item->appendElement($dc_collection_item);

        $main_collection_item->appendElements(Array($de_collection_item, $md_collection_item, $va_collection_item, $wv_collection_item));
        $fetchTime = sprintf('%01.4f', microtime(true) - $st1);
        echo ("<p><em>The test took $fetchTime seconds.</em></p>");
        
        $hierarchy = $main_collection_item->getHierarchy();
        display_raw_hierarchy($hierarchy, '09');
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
        $st1 = microtime(true);
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
        
        $item_list = $access_instance->generic_search(Array('access_class' => 'CO_US_Place', 'tags' => Array(NULL, NULL, NULL, NULL, NULL, 'DC')));
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            if (!$dc_collection_item->appendElements($item_list)) {
                echo("<h3 style=\"color:red;font-weight:bold\">Unable to add items!</h3>");
                $item_list = NULL;
            }
        }
        
        if (isset($item_list) && is_array($item_list) && count($item_list)) {
            $main_collection_item->appendElement($de_collection_item);
        
            $fetchTime = sprintf('%01.4f', microtime(true) - $st1);
            echo ("<p><em>The test took $fetchTime seconds.</em></p>");
        
            $hierarchy = $main_collection_item->getHierarchy();
            display_raw_hierarchy($hierarchy, '10');
    
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
        $st1 = microtime(true);
        $main_collection_item = $access_instance->get_single_data_record_by_id(11);
        $fetchTime = sprintf('%01.4f', microtime(true) - $st1);
        echo ("<p><em>The test took $fetchTime seconds.</em></p>");
        
        $hierarchy = $main_collection_item->getHierarchy();
        display_raw_hierarchy($hierarchy, '11');
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
        $dc_collection = $access_instance->get_single_data_record_by_id(2);
        $va_collection = $access_instance->get_single_data_record_by_id(3);
        $md_collection = $access_instance->get_single_data_record_by_id(4);
        $dc_va_collection = $access_instance->get_single_data_record_by_id(8);
        $dc_area_collection = $access_instance->get_single_data_record_by_id(11);
        
        $dc_1 = $access_instance->get_single_data_record_by_id(144);
        $va_1 = $access_instance->get_single_data_record_by_id(26);
        $md_1 = $access_instance->get_single_data_record_by_id(42);

        $dc_2 = $access_instance->get_single_data_record_by_id(146);
        $va_2 = $access_instance->get_single_data_record_by_id(49);
        $md_2 = $access_instance->get_single_data_record_by_id(94);
        
        $dc_3 = $access_instance->get_single_data_record_by_id(553);
        $va_3 = $access_instance->get_single_data_record_by_id(358);
        $md_3 = $access_instance->get_single_data_record_by_id(95);
        
        $dc_4 = $access_instance->get_single_data_record_by_id(691);
        $va_4 = $access_instance->get_single_data_record_by_id(359);
        $md_4 = $access_instance->get_single_data_record_by_id(103);
        
        $dc_collection->appendElements(Array($dc_1, $dc_2, $dc_3, $dc_4));
        $va_collection->appendElements(Array($va_1, $va_2, $va_3, $va_4));
        $md_collection->appendElements(Array($md_1, $md_2, $md_3, $md_4));
        $dc_va_collection->appendElements(Array($dc_collection, $va_collection));
        $dc_area_collection->appendElements(Array($md_collection, $dc_va_collection));
        
        echo("<h3>We have a bunch of collections set up. We will now try to add a collection that is already in the hierarchy. It should fail.</h3>");
        
        if ($dc_area_collection->appendElements(Array($md_collection, $va_collection))) {
            echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE SUCEEDED!</h3>");
        } else {
            echo("<h3>That worked.</h3>");
            echo("<h3>Now, let's make sure we can add regular items that are already in the hierarchy.</h3>");
            if (!$dc_area_collection->appendElements(Array($va_2, $va_3))) {
                echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE FAILED!</h3>");
            } else {
                echo("<h3>That worked.</h3>");
                if (!$dc_area_collection->appendElement($va_1)) {
                    echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE FAILED!</h3>");
                } else {
                    echo("<h3>We now have two copies of ".$va_1->name.". We wanted three, but duplicates are not allowed in a collection (they are allowed in children collections).</h3>");
                    $daddies = $dc_area_collection->whosYourDaddy($va_1);
                    
                    echo("<h3>We should get two \"parent\" instances.</h3>");
                    echo("<h3>This checks the top-level collection:</h3>");
                    foreach ($daddies as $daddy) {
                        echo('<p>'.htmlspecialchars(print_r($daddy->name, true)).'</p>');
                    }
                    
                    echo("<h3>This checks the Access Object.</h3>");
                    if ($daddies = $access_instance->get_all_collections_for_element($va_1)) {
                        foreach ($daddies as $daddy) {
                            echo('<p>'.htmlspecialchars(print_r($daddy->name, true)).'</p>');
                        }
                    } elseif ($access_instance->error) {
                        echo("<h3 style=\"color:red;font-weight:bold\">ERROR!</h3>");
                        echo('<pre>'.htmlspecialchars(print_r($access_instance, true)).'</pre>');
                    } else {
                        echo("<h3 style=\"color:red;font-weight:bold\">THIS SHOULD NOT HAVE FAILED!</h3>");
                    }
                    
                    $hierarchy = $dc_area_collection->getHierarchy();
                    display_raw_hierarchy($hierarchy, '4-12-1-'.$in_login);

                    echo("<h3>Now, we will change the read ID for the main instance, and it should change for both of the instances in the hierarchy.</h3>");
                    echo("<h3>".$va_1->name." should now all have a read ID of 8:</h3>");
                    $va_1->set_read_security_id(8);
                    $hierarchy = $dc_area_collection->getHierarchy();
                    display_raw_hierarchy($hierarchy, '4-12-2-'.$in_login);
                }
            }
        }
        
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
    echo('<p class="explain">First, we go in with the God Mode ID, and list all available items:</p>');

    $access_instance0 = new CO_Chameleon('admin', '', CO_Config::god_mode_password());
    
    if ($access_instance0->valid) {
        $main_collection_item = $access_instance0->get_single_data_record_by_id(11);
        $hierarchy = $main_collection_item->getHierarchy();
        display_raw_hierarchy($hierarchy, '13A');
        echo('<p class="explain">Next, we go in with the DC Admin ID, and list all available items:</p>');

        $access_instance1 = new CO_Chameleon('DCAdmin', '', 'CoreysGoryStory');
    
        if ($access_instance1->valid) {
            $main_collection_item = $access_instance1->get_single_data_record_by_id(11);
        
            $hierarchy = $main_collection_item->getHierarchy();
            display_raw_hierarchy($hierarchy, '13B');
            
            echo('<p class="explain">Now, we go back as God, and delete "High Noon Hope":</p>');
            $high_noon_hope = $access_instance0->get_single_data_record_by_id(49);
            
            if ($high_noon_hope->delete_from_db()) {
                echo('<p class="explain">Look at the result as God:</p>');
                $main_collection_item = $access_instance0->get_single_data_record_by_id(11);
                $hierarchy = $main_collection_item->getHierarchy();
                display_raw_hierarchy($hierarchy, '13C');
                if ('mysql' == CO_Config::$data_db_type) {
                    echo('<p class="explain">All right, now we manually re-add "High Noon Hope." The idea is that it will no longer be available, even though it is there, because it has been removed from all the collections:</p>');
                    re_add_hn();
                    $main_collection_item = $access_instance0->get_single_data_record_by_id(11);
                    $hierarchy = $main_collection_item->getHierarchy();
                    display_raw_hierarchy($hierarchy, '13D');
                }
            } else {
                echo("<h3 style=\"color:red;font-weight:bold\">The Deletion Failed!</h3>");
                echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$high_noon_hope->error->error_code.') '.$high_noon_hope->error->error_name.' ('.$high_noon_hope->error->error_description.')</p>');
            }
        } else {
            echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
            echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance1->error->error_code.') '.$access_instance1->error->error_name.' ('.$access_instance1->error->error_description.')</p>');
        }
    } else {
        echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
        echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance0->error->error_code.') '.$access_instance0->error->error_name.' ('.$access_instance0->error->error_description.')</p>');
    }
}

function re_add_hn() {
    if ( !defined('LGV_DB_CATCHER') ) {
        define('LGV_DB_CATCHER', 1);
    }

    require_once(CO_Config::db_class_dir().'/co_pdo.class.php');

    if ( !defined('LGV_ERROR_CATCHER') ) {
        define('LGV_ERROR_CATCHER', 1);
    }

    require_once(CO_Config::badger_shared_class_dir().'/error.class.php');
    
    $pdo_data_db = NULL;
    try {
        $pdo_data_db = new CO_PDO(CO_Config::$data_db_type, CO_Config::$data_db_host, CO_Config::$data_db_name, CO_Config::$data_db_login, CO_Config::$data_db_password);
    } catch (Exception $exception) {
// die('<pre style="text-align:left">'.htmlspecialchars(print_r($exception, true)).'</pre>');
                $error = new LGV_Error( 1,
                                        'INITIAL DATABASE SETUP FAILURE',
                                        'FAILED TO INITIALIZE A DATABASE!',
                                        $exception->getFile(),
                                        $exception->getLine(),
                                        $exception->getMessage());
            echo('<h1 style="color:red">ERROR WHILE TRYING TO ACCESS DATABASES!</h1>');
            echo('<pre>'.htmlspecialchars(print_r($error, true)).'</pre>');
    }
    
    if ($pdo_data_db) {
        $data_db_sql = file_get_contents(CO_Config::test_class_dir().'/sql/high_noon.sql');
            
        $error = NULL;

        try {
            $pdo_data_db->preparedExec($data_db_sql);
        } catch (Exception $exception) {
// die('<pre style="text-align:left">'.htmlspecialchars(print_r($exception, true)).'</pre>');
            $error = new LGV_Error( 1,
                                    'RE-ADD DATABASE SETUP FAILURE',
                                    'FAILED TO INITIALIZE A DATABASE!',
                                    $exception->getFile(),
                                    $exception->getLine(),
                                    $exception->getMessage());
                                            
            echo('<h1 style="color:red">ERROR WHILE TRYING TO OPEN DATABASES!</h1>');
            echo('<pre>'.htmlspecialchars(print_r($error, true)).'</pre>');
        }
    
        return;
    }
    
    echo('<h1 style="color:red">UNABLE TO OPEN DATABASE!</h1>');
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
                        collection_test_relay(1, 'admin', '', CO_Config::god_mode_password());
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
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-033\')">TEST 33: Multiple Instance Tests.</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain">This is actually a series of tests, where we make sure that the instance cache works, and that we can\'t add repeated collections.</p>');
                        echo('</div>');
                        collection_test_relay(12, 'AllAdmin', '', 'CoreysGoryStory');
                    echo('</div>');
                echo('</div>');
        
                echo('<div id="test-033A" class="inner_closed">');
                    echo('<h3 class="inner_header"><a href="javascript:toggle_inner_state(\'test-033A\')">TEST 33A: Delete Some Elements, and Make Sure They are "Garbage-Collected."</a></h3>');
                    echo('<div class="main_div inner_container">');
                        echo('<div class="main_div" style="margin-right:2em">');
                            echo('<p class="explain"></p>');
                        echo('</div>');
                        collection_test_relay(13, '', '', '');
                    echo('</div>');
                echo('</div>');

            echo('</div>');
        echo('</div>');
    echo('</div>');
$buffer = ob_get_clean();
die($buffer);
?>
