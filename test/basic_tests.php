<?php
/***************************************************************************************************************************/
/**
    Badger Hardened Baseline Database Component
    
    © Copyright 2018, Little Green Viper Software Development LLC.
    
    This code is proprietary and confidential code, 
    It is NOT to be reused or combined into any application,
    unless done so, specifically under written license from Little Green Viper Software Development LLC.

    Little Green Viper Software Development: https://littlegreenviper.com
*/
?><div style="display:table;margin-left:auto;margin-right:auto;text-align:left">
    <?php
        prepare_databases('basic_test');
        echo('<div id="basic-login-tests" class="closed">');
            echo('<h1 class="header"><a href="javascript:toggle_main_state(\'basic-login-tests\')">READ PLACES</a></h1>');
            echo('<div class="container">');
                echo('<div id="test-001" class="inner_closed">');
                    echo('<h2 class="inner_header"><a href="javascript:toggle_inner_state(\'test-001\')">TEST 1: Log In as "Tertiary", and Read The Entries.</a></h2>');
                    echo('<div class="main_div inner_container">');
                        ?>
                        <div class="main_div" style="margin-right:2em">
                        <p class="explain"></p>
                        </div>
                        <?php
                        test_relay(1, 'tertiary', 'CodYOzPtwxb4A');
                        $start = microtime(TRUE);
                        echo('<h5>The test took '. sprintf('%01.3f', microtime(TRUE) - $start) . ' seconds.</h5>');
                    echo('</div>');
                echo('</div>');
            echo('</div>');
        echo('</div>');
    ?>
</div>
<?php
    function test_relay($in_test_number, $in_login = NULL, $in_hashed_password = NULL, $in_password = NULL) {
        $access_instance = NULL;
        
        if ( !defined('LGV_ACCESS_CATCHER') ) {
            define('LGV_ACCESS_CATCHER', 1);
        }
        
        require_once(CO_Config::chameleon_main_class_dir().'/co_chameleon.class.php');
        
        $access_instance = new CO_Chameleon($in_login, $in_hashed_password, $in_password);
        
        if ($access_instance->valid) {
            echo("<h2>The access instance is valid!</h2>");
        } else {
            echo("<h2 style=\"color:red;font-weight:bold\">The access instance is not valid!</h2>");
            echo('<p style="margin-left:1em;color:red;font-weight:bold">Error: ('.$access_instance->error->error_code.') '.$access_instance->error->error_name.' ('.$access_instance->error->error_description.')</p>');
        }
    }
?>
