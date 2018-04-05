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
    $config_file_path = dirname(__FILE__).'/config/s_config.class.php';
    $data_sql_file_path = dirname(__FILE__).'/sql/badger_test_data.sql';
    $security_sql_file_path = dirname(__FILE__).'/sql/badger_test_security.sql';
    
    date_default_timezone_set ( 'UTC' );
    
    if ( !defined('LGV_CONFIG_CATCHER') ) {
        define('LGV_CONFIG_CATCHER', 1);
    }
    
    require_once($config_file_path);
    
    function prepare_databases($in_file_prefix) {
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
            $pdo_security_db = new CO_PDO(CO_Config::$sec_db_type, CO_Config::$sec_db_host, CO_Config::$sec_db_name, CO_Config::$sec_db_login, CO_Config::$sec_db_password);
            
            if ($pdo_security_db) {
                $data_db_sql = file_get_contents(CO_Config::test_class_dir().'/sql/'.$in_file_prefix.'_data.sql');
                $security_db_sql = file_get_contents(CO_Config::test_class_dir().'/sql/'.$in_file_prefix.'_security.sql');
                
                $error = NULL;
        
                try {
                    $pdo_data_db->preparedExec($data_db_sql);
                    $pdo_security_db->preparedExec($security_db_sql);
                } catch (Exception $exception) {
                    $error = new LGV_Error( 1,
                                            'INITIAL DATABASE SETUP FAILURE',
                                            'FAILED TO INITIALIZE A DATABASE!',
                                            $exception->getFile(),
                                            $exception->getLine(),
                                            $exception->getMessage());
                                                    
                echo('<h1 style="color:red">ERROR WHILE TRYING TO OPEN DATABASES!</h1>');
                echo('<pre>'.htmlspecialchars(print_r($error, true)).'</pre>');
                }
            return;
            }
        }
        echo('');
        echo('<h1 style="color:red">UNABLE TO OPEN DATABASE!</h1>');
    }
    
    function display_record($in_record_object) {
        echo("<h5 style=\"margin-top:0.5em\">ITEM ".$in_record_object->id().":</h5>");
        if (isset($in_record_object) && $in_record_object) {
            echo('<div class="inner_div">');
                $access_object = $in_record_object->get_access_object();
                if ($access_object) {
                    $login_item = $access_object->get_login_item();
                    if ($login_item) {
                        echo('<p style="font-style:italic;margin-top:0.25em;margin-bottom:0.25em">'.'This user ("'.$login_item->login_id.'"), is logged in as "'.$login_item->login_id.'" ('.implode(', ', $login_item->ids).').</p>');
                        if ($in_record_object->user_can_write()) {
                            echo('<p style="color: green;font-weight:bold;font-size:large;font-style:italic;margin-bottom:0.25em">This user can modify this record.</p>');
                        }
                    }
                }
                
                echo("<p>$in_record_object->class_description</p>");
                echo("<p>$in_record_object->instance_description</p>");
                echo("<p>Read: $in_record_object->read_security_id</p>");
                echo("<p>Write: $in_record_object->write_security_id</p>");
            
                if (isset($in_record_object->owner_id) && intval($in_record_object->owner_id)) {
                    echo("<p>Owner: ".intval($in_record_object->owner_id)."</p>");
                }
            
                if (isset($in_record_object->last_access)) {
                    echo("<p>Last access: ".date('g:i:s A, F j, Y', $in_record_object->last_access)."</p>");
                }
            
                if (isset($in_record_object->distance)) {
                    $distance = sprintf('%01.3f', $in_record_object->distance);
                    echo("<p>Distance: $distance"."Km</p>");
                }
            
                if (isset($in_record_object->tags)) {
                    if ($in_record_object instanceof CO_Place) {
                        foreach ($in_record_object->address_elements as $key => $value) {
                            if (trim($value)) {
                                echo("<p>$key: \"$value\"</p>");
                            }
                        }
                        if ($in_record_object instanceof CO_US_Place) {
                            echo("<p>Tag 7: \"".$in_record_object->tags[7]."\"</p>");
                        }
                        echo("<p>Tag 8: \"".$in_record_object->tags[8]."\"</p>");
                        echo("<p>Tag 9: \"".$in_record_object->tags[9]."\"</p>");
                        $address = $in_record_object->get_readable_address();
                        if ($address) {
                            echo("<p>Address: \"$address.\"</p>");
                        }
                    } else {
                        foreach ($in_record_object->tags as $key => $value) {
                            echo("<p>Tag $key: \"$value\"</p>");
                        }
                    }
                }
            
                if ( $in_record_object instanceof CO_Security_Login) {
                    if ( isset($in_record_object->ids) && is_array($in_record_object->ids) && count($in_record_object->ids)) {
                        echo("<p>IDs: ");
                            $first = TRUE;
                            foreach ( $in_record_object->ids as $id ) {
                                if (!$first) {
                                    echo(", ");
                                } else {
                                    $first = FALSE;
                                }
                                echo($id);
                            }
                        echo("</p>");
                    } else {
                        echo("<h4>NO IDS!</h4>");
                    }
                }
            echo('</div>');
        } else {
            echo("<h4>Invalid Object!</h4>");
        }
    }
        
?>