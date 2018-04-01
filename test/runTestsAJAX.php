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
$start_time = microtime(TRUE);

?><img src="../icon.png" style="display:block;margin:auto;width:80px" alt="A Lump of COAL" />
<div id="basic_tests" class="test-wrapper">
    <h2>BASIC TESTS</h2>
    <?php
    include('test_scripts/basic_tests.php');
    ?>
</div>
<?php
$end_time = microtime(TRUE);
$seconds = $end_time - $start_time;
$minutes = intval($seconds / 60.0);
$seconds -= floatval($minutes * 60);
echo("<h3 style=\"margin-top:1em\">The entire test suite took ".(((0 < $minutes) ? "$minutes minute".((1 < $minutes) ? 's' : ''). ' and ' : '')).sprintf('%01.3f', $seconds)." seconds to run.</h3>");
?>
