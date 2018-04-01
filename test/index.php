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

require_once(dirname(__FILE__).'/functions.php');

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
            
            div.inner_div {
                margin-top:0.25em;
                margin-left:1em;
                padding: 0.25em;
            }
            
            .explain {
                font-style: italic;
            }
            
            h1.header {
                font-size: large;
                margin-top: 1em;
                text-align:center;
            }
            
            div.open h1.header {
            }
            
            div.closed h1.header {
            }
            
            div.open div.container {
                margin-left:1em;
                display: block;
            }
            
            div.closed div.container {
                display: none;
            }
            
            h2.inner_header {
                font-size: medium;
            }
            
            div.inner_open h2.inner_header {
            }
            
            div.inner_closed h2.inner_header {
            }
            
            div.inner_open div.inner_container {
                margin-left:1em;
                display: block;
                border:1px dashed #555;
            }
            
            div.inner_closed div.inner_container {
                display: none;
            }
            
            div.test-wrapper {
                display: table;
                margin:auto;
                padding: 0.25em;
                margin-top:1em;
                border-radius:0.5em;
                border:2px solid #999;
                min-width:30em;
            }
            
        </style>
        
        <script type="text/javascript">
            function toggle_main_state(in_id) {
                var item = document.getElementById(in_id);
                
                if ( item.className == 'closed' ) {
                    item.className = 'open';
                } else {
                    item.className = 'closed';
                };
            };
            
            function toggle_inner_state(in_id) {
                var item = document.getElementById(in_id);
                
                if ( item.className == 'inner_closed' ) {
                    item.className = 'inner_open';
                } else {
                    item.className = 'inner_closed';
                };
                
            };
            
            function expose_tests() {
                var item = document.getElementById('throbber-container');
                
                if (item) {
                    item.style="display:none";
                };
                
                var item = document.getElementById('tests-wrapped-up');
                
                if (item) {
                    item.style="display:block";
                };
            };
            
            window.onload = expose_tests;
        </script>
    </head>
    <body>
        <h1 style="text-align:center">CHAMELEON OBJECT ABSTRACTION LAYER</h1>
        <div style="text-align:center;padding:1em;">
            <?php
                if (!isset($_GET['run_tests'])) {
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
                <h3><a href="./?run_tests">RUN THE FUNCTIONAL TESTS</a></h3>
                <h3 style="margin-top:1em"><a href="./mapDemo.php">RUN THE MAP DEMO TEST</a></h3>
            </div>
            <?php } else {
                $start_time = microtime(TRUE);
            ?>
                <div id="throbber-container" style="text-align:center"><img src="images/throbber.gif" alt="throbber" style="position:absolute;width:190px;top:50%;left:50%;margin-top:-95px;margin-left:-95px" /></div>
                <div id="tests-wrapped-up" style="display:none">
                    <img src="../icon.png" style="display:block;margin:auto;width:80px" alt="A Lump Of COAL" />
                    <div id="basic_tests" class="test-wrapper">
                        <h2>BASIC TESTS</h2>
                        <?php
                        include('basic_tests.php');
                        ?>
                    </div>
                    <?php
                        $end_time = microtime(TRUE);
                        $seconds = $end_time - $start_time;
                        $minutes = intval($seconds / 60.0);
                        $seconds -= floatval($minutes * 60);
                        echo("<h3 style=\"margin-top:1em\">The entire test suite took ".(((0 < $minutes) ? "$minutes minute".((1 < $minutes) ? 's' : ''). ' and ' : '')).sprintf('%01.3f', $seconds)." seconds to run.</h3>");
                    ?>
                    <h3 style="margin-top:1em"><a href="./">RETURN TO MAIN ENVIRONMENT SETUP</a></h3>
                </div>
            <?php } ?>
        </div>
    </body>
</html>

