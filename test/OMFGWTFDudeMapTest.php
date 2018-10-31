<?php
/***************************************************************************************************************************/
/**
    CHAMELEON Object Abstraction Layer
    
    © Copyright 2018, Little Green Viper Software Development LLC/The Great Rift Valley Software Company
    
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

    Little Green Viper Software Development: https://littlegreenviper.com
*/

$config_file_path = dirname(__FILE__).'/config/omfgwtfdude_config.class.php';

if ( !defined('LGV_CONFIG_CATCHER') ) {
    define('LGV_CONFIG_CATCHER', 1);
}

require_once($config_file_path);
require_once(dirname(__FILE__).'/functions.php');

set_time_limit ( 60 * 60 * 2 );

function prepare_omfg_databases() {
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
// die('<pre>'.htmlspecialchars(print_r($exception, true)).'</pre>');
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
            $error = NULL;
    
            try {
                $test = $pdo_data_db->preparedQuery('SELECT id FROM co_data_nodes WHERE id=100000;');
                if (0 == count($test)) {               
                    $input = fopen(CO_Config::test_class_dir().'/sql/OMFGWTFDudeTestDataset_'.CO_Config::$data_db_type.'.sql', 'r+');
            
                    if ($input) {
                        $build_command = '';
                        while($line = fgets($input)) {
                            $build_command .= $line;
                            if (false !== strpos($line, ';')) {
                                $pdo_data_db->preparedExec($build_command);
                                $build_command = '';
                            }
                        }
                    }
            
                    $security_db_sql = file_get_contents(CO_Config::test_class_dir().'/sql/OMFGWTFDudeTestSecurity_'.CO_Config::$data_db_type.'.sql');
        
                    $pdo_security_db->preparedExec($security_db_sql);
                }
            } catch (Exception $exception) {
// die('<pre>'.htmlspecialchars(print_r($exception, true)).'</pre>');
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

if ( !defined('LGV_ACCESS_CATCHER') ) {
    define('LGV_ACCESS_CATCHER', 1);
}

require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');

if (isset($_GET['resolve_query'])) {
    $access_instance = new CO_Chameleon();

    echo('[');
    if ($access_instance->valid) {
        list($long, $lat, $radius) = array_map('floatval', explode(',', trim($_GET['resolve_query'])));
        $test_item = $access_instance->generic_search(Array('location' => Array('longitude' => $long, 'latitude' => $lat, 'radius' => $radius)));
        if (isset($test_item) && is_array($test_item) && count($test_item)) {
            $test = array_map(function($item){return '{"id":'.intval($item->id()).',"name":'.json_encode($item->name).',"longitude":'.floatval($item->longitude()).',"latitude":'.floatval($item->latitude()).',"owner":'.intval($item->owner_id()).',"distance":'.floatval($item->distance).'}';}, $test_item);
            echo(implode(',',$test));
        }
    }
    echo(']');
    exit();
} elseif (isset($_GET['loadDB'])) {
    prepare_omfg_databases();
    exit();
} else {
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="../icon.png" type="image/png" />
        <title>Badger Map Demo</title>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyC5meofXldluts0UPGp6Zg234-U989u1pY&libraries=geometry"></script>
        <script type="text/javascript" src="OMFGWTFDudeMapTest.js"></script>
        <style>
            *{margin:0;padding:0}
            html, body, .map_div {
                width: 100%;
                height: 100%;
            }
            body {
                font-family: Arial, San-serif;
            }
            div.centerControlDiv {
                background-color: white;
                padding: 0.25em;
            }
        </style>
    </head>
    <body>
        <div style="width:100%;height:100%">
            <div id="map-container" class="map_div" style="position:absolute;width:100%;height:100%;top:0px;left:0px;z-axis:20000"></div>
            <h1 id="chill-dude" style="text-align:center">This Gonna Take A While. Go catch a show, or something.</h1>
            <img id="throbber-container" src="images/throbber.gif" alt="throbber" style="z-axis:20001;position:absolute;width:190px;top:50%;left:50%;margin-top:-95px;margin-left:-95px" />
            <?php
            $access_instance = NULL;
    
            $access_instance = new CO_Chameleon();
    
            if ($access_instance->valid) {
                echo('<script type="text/javascript">new loadTestMap()</script>');
            }
            ?>
        </div>
    </body>
</html>
<?php
}
?>