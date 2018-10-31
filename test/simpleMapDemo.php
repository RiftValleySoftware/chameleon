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

require_once(dirname(__FILE__).'/functions.php');

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
            $test = array_map(function($item){return '{"id":'.intval($item->id()).',"name":'.json_encode($item->name).',"longitude":'.floatval($item->longitude()).',"latitude":'.floatval($item->latitude()).',"distance":'.floatval($item->distance).',"weekday":'.intval($item->tags()[8]).',"address":"'.addslashes($item->get_readable_address()).'"}';}, $test_item);
            echo(implode(',',$test));
        }
    }
    echo(']');
    exit();
} elseif (isset($_GET['loadDB'])) {
    prepare_databases('stress_tests');
    exit();
} else {
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="../icon.png" type="image/png" />
        <title>Badger Map Demo</title>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyC5meofXldluts0UPGp6Zg234-U989u1pY&libraries=geometry"></script>
        <script type="text/javascript" src="simpleMapDemo.js"></script>
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