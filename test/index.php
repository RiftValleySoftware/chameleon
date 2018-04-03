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

if ( !defined('LGV_CONFIG_CATCHER') ) {
    define('LGV_CONFIG_CATCHER', 1);
}

require_once($config_file_path);

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>A Lump of COAL</title>
        <link rel="shortcut icon" href="../icon.png" type="image/png" />
        <style>
            *{margin:0;padding:0}
            body {
                font-family: Arial, San-serif;
                }
            
            div.main_div {
                margin-top:0.25em;
                margin-bottom: 0.25em;
                margin-left:1em;
                padding: 0.5em;
            }
            
            .explain {
                font-style: italic;
            }
            
            h1.header {
                font-size: large;
                margin-top: 1em;
                text-align:center;
            }
            
        </style>
    </head>
    <body>
        <h1 style="text-align:center">CHAMELEON OBJECT ABSTRACTION LAYER</h1>
        <div style="text-align:center;padding:1em;">
            <?php
                if ( !defined('LGV_ACCESS_CATCHER') ) {
                    define('LGV_ACCESS_CATCHER', 1);
                }
    
                require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
            ?>
            <img src="../icon.png" style="display:block;margin:auto;width:80px" alt="A Lump of COAL" />
            <h1 class="header">MAIN ENVIRONMENT SETUP</h1>
            <div style="text-align:left;margin:auto;display:table">
                <div class="main_div container">
                    <?php
                        echo("<div style=\"margin:auto;text-align:center;display:table\">");
                        echo("<h2>File/Folder Locations</h2>");
                        echo("<pre style=\"margin:auto;text-align:left;display:table\">");
                        echo("<strong>CHAMELEON Version</strong>.....".__CHAMELEON_VERSION__."\n");
                        echo("<strong>BADGER Version</strong>........".__BADGER_VERSION__."\n");
                        echo("<strong>CHAMELEON Base dir</strong>....".CO_Config::base_dir()."\n");
                        echo("<strong>BADGER Base dir</strong>.......".CO_Config::badger_base_dir()."\n");
                        echo("<strong>Extension classes dir</strong>.".CO_Config::db_classes_extension_class_dir()."\n");
                        echo("</pre></div>");
                    ?>
                    <div class="main_div">
                        <h2 style="text-align:center">Instructions</h2>
                        <p class="explain">In order to run these tests, you should set up two (2) blank databases. They can both be the same DB, but that is not the advised configuration for Badger.</p>
                        <p class="explain">The first (main) database should be called "<?php echo(CO_Config::$data_db_name) ?>", and the second (security) database should be called "<?php echo(CO_Config::$sec_db_name) ?>".</p>
                        <p class="explain">The main database should be have a full rights login named "<?php echo(CO_Config::$data_db_login) ?>", with a password of "<?php echo(CO_Config::$data_db_password) ?>".</p>
                        <p class="explain">The security database should have a full rights login named "<?php echo(CO_Config::$sec_db_login) ?>", with a password of "<?php echo(CO_Config::$sec_db_password) ?>".</p>
                        <p class="explain" style="font-weight:bold;color:red;font-style:italic">This test will wipe out the tables, and set up pre-initialized tables, so it goes without saying that these should be databases (and users) reserved for testing only.</p>
                    </div>
                </div>
            </div>
            <h3><a href="./runTests.php">RUN THE FUNCTIONAL TESTS</a></h3>
            <h3 style="margin-top:1em"><a href="./simpleMapDemo.php">RUN THE "BIG" MAP DEMO TEST</a></h3>
            <h3 style="margin-top:1em"><a href="./dcAreaMapDemo.php">RUN THE DC AREA MAP DEMO TEST</a></h3>
            <h3 style="margin-top:1em"><a href="../badger/test/">BADGER TESTS</a></h3>
        </div>
    </body>
</html>

