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

loadTestMap = function() {
    this.loadDatabase();
};

loadTestMap.prototype.m_icon_image_single = null;
loadTestMap.prototype.m_icon_image_multi = null;
loadTestMap.prototype.m_icon_shadow = null;
loadTestMap.prototype.m_main_map = null;
loadTestMap.prototype.m_meeting_array = null;
loadTestMap.prototype.m_current_task = null;
loadTestMap.prototype.m_display_all_radio = null;
loadTestMap.prototype.m_display_md_radio = null;
loadTestMap.prototype.m_display_va_radio = null;
loadTestMap.prototype.m_display_dc_radio = null;
loadTestMap.prototype.m_display_wv_radio = null;
loadTestMap.prototype.m_display_de_radio = null;

loadTestMap.prototype.loadMap = function() {
	this.m_icon_image_single = new google.maps.MarkerImage ( "images/MarkerB.png", new google.maps.Size(22, 32), new google.maps.Point(0,0), new google.maps.Point(12, 32) );
	this.m_icon_image_multi = new google.maps.MarkerImage ( "images/MarkerR.png", new google.maps.Size(22, 32), new google.maps.Point(0,0), new google.maps.Point(12, 32) );
	this.m_icon_shadow = new google.maps.MarkerImage( "images/MarkerS.png", new google.maps.Size(43, 32), new google.maps.Point(0,0), new google.maps.Point(12, 32) );
    this.m_meeting_array = new Array();
    this.m_current_task = null;
    
    if ( !this.m_main_map )
        {
        var myOptions = {
                        'center': new google.maps.LatLng(38.3, -78.6),
                        'zoom': 8,
                        'mapTypeId': google.maps.MapTypeId.ROADMAP,
                        'mapTypeControlOptions': { 'style': google.maps.MapTypeControlStyle.DROPDOWN_MENU },
                        'zoomControl': true,
                        'mapTypeControl': true,
                        'clickableIcons': false,
                        'draggableCursor': "crosshair",
                        'scaleControl' : true
                        };

        myOptions.zoomControlOptions = { 'style': google.maps.ZoomControlStyle.LARGE };

        this.m_main_map = new google.maps.Map(document.getElementById('map-container'), myOptions);

        if ( this.m_main_map ) {
            this.m_main_map.map_marker = null;
            this.m_main_map.context = this;
            this.m_main_map.m_markers_array = new Array();
            this.m_main_map.m_calculated_markers_array = new Array();
            this.m_main_map.m_ru_paul = false;
            this.m_main_map.m_info_window_opening = false;
    
            google.maps.event.addListener(this.m_main_map, 'click', this.mapClicked);
            google.maps.event.addListenerOnce(this.m_main_map, 'tilesloaded', this.mapLoaded);
            this.setUpRadiobuttonBox();
        };
    };
};

loadTestMap.prototype.mapLoaded = function() {
    var myBounds = this.getBounds();
    
    if (myBounds) {
        var mapHeightInMeters = Math.abs(google.maps.geometry.spherical.computeDistanceBetween(myBounds.getNorthEast(), myBounds.getSouthWest()) / 2.0);
        
        this.m_previous_zoom = this.getZoom();
        this.m_previous_center = this.getCenter();
        google.maps.event.addListener(this, 'bounds_changed', this.context.mapBoundsChanged);
        google.maps.event.addListener(this, 'dragstart', this.context.mapDragStart);
        google.maps.event.addListener(this, 'dragend', this.context.mapDragEnd);
        this.context.setUpMarkers();
    };
};

loadTestMap.prototype.setUpMarkers = function() {
    var myBounds = this.m_main_map.getBounds();

    if (myBounds) {
        var mapHeightInMeters = Math.abs(google.maps.geometry.spherical.computeDistanceBetween(myBounds.getNorthEast(), myBounds.getSouthWest()) / 2.0);
        this.m_main_map.radius = mapHeightInMeters;
        this.m_main_map.m_previous_zoom = this.m_main_map.getZoom();
        this.m_main_map.m_previous_center = this.m_main_map.getCenter();
        this.m_main_map.m_info_window_opening = false;
        this.m_main_map.m_ru_paul = false;
        this.getNewMarkers();
    };
};

loadTestMap.prototype.setUpRadiobutton = function( inButtonValue,
                                        inName,
                                        inSelected,
                                        inButtonText,
                                        inCallback
                                        ) {
    var containerElement = document.createElement ( 'div' );
    if ( containerElement ) {
        var radiobuttonElement = document.createElement ( 'input' );
        if ( radiobuttonElement ) {
            radiobuttonElement.type = 'radio';
            radiobuttonElement.name = inName;
            radiobuttonElement.value = inButtonValue;
            radiobuttonElement.baseClassName = 'state_select'
            radiobuttonElement.className = radiobuttonElement.baseClassName + '_radiobutton' + (inSelected ? '_selected' : '' );
            radiobuttonElement.id = inName + '_' + inButtonValue + '_' + radiobuttonElement.baseClassName + '_radiobutton';
            radiobuttonElement.checked = inSelected;
            radiobuttonElement.context = this;

            var handler = function ( radiobuttonElement ) {
                    radiobuttonElement.className = radiobuttonElement.baseClassName + '_radiobutton' + (inSelected ? '_selected' : '' );
                    inCallback(radiobuttonElement);
                };

            radiobuttonElement.addEventListener ( 'click', function () { handler(this); } );
            
            containerElement.appendChild ( radiobuttonElement );
            
            var labelElement = document.createElement ( 'label' );
            if ( labelElement ) {
                labelElement.htmlFor = radiobuttonElement.id;
                labelElement.innerHTML = inButtonText;
                containerElement.appendChild ( labelElement );
                containerElement.radiobutton = radiobuttonElement;
                return containerElement;
            };
        };
    };
    
    return null;
};

loadTestMap.prototype.setUpRadiobuttonBox = function() {
    var centerControlDiv = document.createElement ( 'div' );
    if (centerControlDiv) {
        this.m_display_all_radio = this.setUpRadiobutton('all', 'admin', true, 'All Admins', this.radioSelected);
        this.m_display_md_radio = this.setUpRadiobutton('md', 'admin', false, 'Maryland', this.radioSelected);
        this.m_display_va_radio = this.setUpRadiobutton('va', 'admin', false, 'Virginia', this.radioSelected);
        this.m_display_dc_radio = this.setUpRadiobutton('dc', 'admin', false, 'DC', this.radioSelected);
        this.m_display_wv_radio = this.setUpRadiobutton('wv', 'admin', false, 'West Virginia', this.radioSelected);
        this.m_display_de_radio = this.setUpRadiobutton('de', 'admin', false, 'Delaware', this.radioSelected);
        
        centerControlDiv.id = "centerControlDiv";
        centerControlDiv.className = "centerControlDiv";
        var radioDiv = document.createElement ( 'div' );
        if (radioDiv) {
            radioDiv.id = "radioDiv";
            radioDiv.className = "radioDiv";
            radioDiv.appendChild ( this.m_display_all_radio );
            radioDiv.appendChild ( this.m_display_md_radio );
            radioDiv.appendChild ( this.m_display_va_radio );
            radioDiv.appendChild ( this.m_display_dc_radio );
            radioDiv.appendChild ( this.m_display_wv_radio );
            radioDiv.appendChild ( this.m_display_de_radio );
            
            centerControlDiv.appendChild ( radioDiv );
        
            var buttonDiv = document.createElement ( 'div' );
            if (buttonDiv) {
                buttonDiv.id = "buttonDiv";
                buttonDiv.className = "buttonDiv";
                var toggleButton = document.createElement ( 'input' );
                toggleButton.type = 'button';
                toggleButton.value = "Return to Main Test Page";
                toggleButton.className = "returnTestPageButton";
                toggleButton.addEventListener ( 'click', this.returnToTest );
                buttonDiv.appendChild ( toggleButton );
                centerControlDiv.appendChild ( buttonDiv );
            };
        };

        this.m_main_map.controls[google.maps.ControlPosition.TOP_CENTER].push ( centerControlDiv );
    };
};

loadTestMap.prototype.returnToTest = function() {
    window.location.href = './';
};

loadTestMap.prototype.radioSelected = function(inRadioButton
                                    ) {
    inRadioButton.context.getNewMarkers();
};

loadTestMap.prototype.mapDragStart = function() {
    this.m_ru_paul = true;
    this.m_previous_zoom = this.getZoom();
    this.m_previous_center = this.getCenter();
    this.context.removeMeetingMarkers();
};

loadTestMap.prototype.mapDragEnd = function() {
    this.m_ru_paul = false;
    this.context.setUpMarkers();
};

loadTestMap.prototype.mapBoundsChanged = function() {
    if (!this.m_info_window_opening && !this.m_ru_paul && ((this.m_previous_zoom != this.getZoom()) || (this.m_previous_center != this.getCenter()))) {
        this.context.setUpMarkers();
    };
    
    this.m_info_window_opening = false;
};

loadTestMap.prototype.getNewMarkers = function() {
    var throbberContainer = document.getElementById('throbber-container');
    throbberContainer.style.display = 'block';
    var position = this.m_main_map.getCenter();
    this.makeRequest(position.lng(), position.lat(), this.m_main_map.radius);
};

/********************************************************************************************//**
*	\brief                                                                                      *
************************************************************************************************/
loadTestMap.prototype.removeMeetingMarkers = function() {
    if ( this.m_main_map ) {
        while(this.m_main_map.m_markers_array.length) {
            this.m_main_map.m_markers_array.pop().setMap(null);
        };
        
        this.m_main_map.m_markers_array = Array();
        this.m_main_map.m_calculated_markers_array = Array();
    };
    
    this.m_meeting_array = Array();
};

/********************************************************************************************//**
*	\brief                                                                                      *
************************************************************************************************/
loadTestMap.prototype.closeInfoWindows = function() {
    if ( this.m_main_map ) {
        this.m_main_map.m_markers_array.map(function(inMarker){inMarker.infoWin.close();});
    };
};
    
/********************************************************************************************//**
*	\brief                                                                                      *
************************************************************************************************/
loadTestMap.prototype.displayMeetingMarkers = function() {
    if ( this.m_main_map && this.m_main_map.getBounds() ) {
        if ( !this.m_main_map.m_calculated_markers_array.length ) {
            this.m_main_map.m_calculated_markers_array = this.sMapOverlappingMarkers ( this.m_meeting_array, this.m_main_map );
        };

        if ( !this.whatADrag && !this.inDraw ) {
            for ( var c = 0; this.m_main_map.m_calculated_markers_array && (c < this.m_main_map.m_calculated_markers_array.length); c++ ) {
                var objectItem = this.m_main_map.m_calculated_markers_array[c];
                var matchesWeDontNeedNoSteenkinMatches = objectItem.matches;
                var marker = this.displayMeetingMarkerInResults ( matchesWeDontNeedNoSteenkinMatches );
                if ( marker ) {
                    this.m_main_map.m_markers_array.push(marker);
                };
            };
        };
        
        var throbberContainer = document.getElementById('throbber-container');
        throbberContainer.style.display = 'none';
    };
};

/********************************************************************************************//**
*   \brief                                                                                      *
************************************************************************************************/
loadTestMap.prototype.sMapOverlappingMarkers = function ( in_meeting_array
									                    ) {
    var tolerance = 16;	/* This is how many pixels we allow. */
    var tmp = new Array;

    for ( var c = 0; c < in_meeting_array.length; c++ ) {
        tmp[c] = new Object;
        tmp[c].matched = false;
        tmp[c].matches = null;
        tmp[c].object = in_meeting_array[c];
        tmp[c].coords = this.sFromLatLngToPixel ( new google.maps.LatLng ( tmp[c].object.latitude, tmp[c].object.longitude ), this.m_main_map );
    };
    
    for ( var c = 0; c < in_meeting_array.length; c++ ) {
        if ( false == tmp[c].matched ) {
            tmp[c].matched = true;
            tmp[c].matches = new Array ( tmp[c].object );

            for ( var c2 = 0; c2 < in_meeting_array.length; c2++ ) {
                if ( false == tmp[c2].matched && tmp[c] && tmp[c2] ) {
                    var outer_coords = tmp[c].coords;
                    var inner_coords = tmp[c2].coords;
                
                    if ( outer_coords && inner_coords ) {
                        var xmin = outer_coords.x - tolerance;
                        var xmax = outer_coords.x + tolerance;
                        var ymin = outer_coords.y - tolerance;
                        var ymax = outer_coords.y + tolerance;
                
                        /* We have an overlap. */
                        if ( (inner_coords.x >= xmin) && (inner_coords.x <= xmax) && (inner_coords.y >= ymin) && (inner_coords.y <= ymax) ) {
                            tmp[c].matches[tmp[c].matches.length] = tmp[c2].object;
                            tmp[c2].matched = true;
                        };
                    };
                };
            };
        };
    };

    var ret = Array ();
    
    for ( var c = 0; c < in_meeting_array.length; c++ ) {
        if ( tmp[c].matches ) {
            ret.push ( tmp[c] );
        };
    };
    
    return ret;
};
    
/********************************************************************************************//**
*	\brief This takes a latitude/longitude location, and returns an x/y pixel location for it.  *
*																						        *
*	\returns a Google Maps API V3 Point, with the pixel coordinates (top, left origin).	        *
************************************************************************************************/
loadTestMap.prototype.sFromLatLngToPixel = function ( in_Latng
                                                    ) {
    var	ret = null;
    
    if ( this.m_main_map ) {
        var	lat_lng_bounds = this.m_main_map.getBounds();
        if ( lat_lng_bounds ) {
            // We measure the container div element.
            var	div = this.m_main_map.getDiv();
    
            if ( div ) {
                var	pixel_width = div.offsetWidth;
                var	pixel_height = div.offsetHeight;
                var north_west_corner = new google.maps.LatLng ( lat_lng_bounds.getNorthEast().lat(), lat_lng_bounds.getSouthWest().lng() );
                var lng_width = lat_lng_bounds.getNorthEast().lng()-lat_lng_bounds.getSouthWest().lng();
                var	lat_height = lat_lng_bounds.getNorthEast().lat()-lat_lng_bounds.getSouthWest().lat();
        
                // We do this, so we have the largest values possible, to get the most accuracy.
                var	pixels_per_degree = (( pixel_width > pixel_height ) ? (pixel_width / lng_width) : (pixel_height / lat_height));
        
                // Figure out the offsets, in long/lat degrees.
                var	offset_vert = north_west_corner.lat() - in_Latng.lat();
                var	offset_horiz = in_Latng.lng() - north_west_corner.lng();
        
                ret = new google.maps.Point ( Math.round(offset_horiz * pixels_per_degree),  Math.round(offset_vert * pixels_per_degree) );
            };
        };
    };

    return ret;
};

/********************************************************************************************//**
*	\brief                                                                                      *
************************************************************************************************/
loadTestMap.prototype.displayMeetingMarkerInResults = function(   in_mtg_obj_array
                                                                ) {
    if ( in_mtg_obj_array && in_mtg_obj_array.length ) {
        var bounds = this.m_main_map.getBounds();
		var main_point = new google.maps.LatLng ( in_mtg_obj_array[0].latitude, in_mtg_obj_array[0].longitude );

        if ( bounds.contains ( main_point ) ) {
            var displayed_image = (in_mtg_obj_array.length == 1) ? this.m_icon_image_single : this.m_icon_image_multi;
            
            var marker_html = '<div><dl>';
        
            var new_marker = new google.maps.Marker (
                                                        {
                                                        'position':     main_point,
                                                        'map':		    this.m_main_map,
                                                        'shadow':		this.m_icon_shadow,
                                                        'icon':			displayed_image,
                                                        'clickable':    true
                                                        } );
        
            var id = this.m_uid;
            new_marker.meeting_id_array = new Array;
            new_marker.meeting_obj_array = in_mtg_obj_array;
            
            // We save all the meetings represented by this marker.
            for ( var c = 0; c < in_mtg_obj_array.length; c++ ) {
                if ( marker_html ) {
                    var weekdays = ['ERROR', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		            marker_html += '<dt><strong>';
		            marker_html += in_mtg_obj_array[c]['name'];
		            marker_html += '</strong></dt>';
		            marker_html += '<dd><em>';
		            marker_html += weekdays[parseInt(in_mtg_obj_array[c]['weekday'])];
		            marker_html += '</em></dd>';
		            marker_html += '<dd>';
		            marker_html += in_mtg_obj_array[c]['address'];
		            marker_html += '</dd>';
		            marker_html += '<dd>Admin: ';
		            marker_html += in_mtg_obj_array[c]['admin'];
		            marker_html += '</dd>';
                };
                
                new_marker.meeting_id_array[c] = in_mtg_obj_array[c]['id'];
            };

            if ( marker_html ) {
		        marker_html += '</dl></div>';
                var infowindow = new google.maps.InfoWindow ( { content: marker_html });
                infowindow.context = this;
                new_marker.infoWin = infowindow;
                new_marker.addListener ( 'click', function() { infowindow.context.m_main_map.m_info_window_opening = true; infowindow.context.closeInfoWindows(); infowindow.open ( this.m_main_map, new_marker ); });
            };
                
            return new_marker;
        };
    };
        
    return null;
};

loadTestMap.prototype.makeRequest = function(in_long, in_lat, in_radius_in_m) {
    var uri = 'dcAreaMapDemo.php?resolve_query=' + in_long.toString() + ',' + in_lat.toString() + ',' + (in_radius_in_m / 1000.0);
    
    if (this.m_display_md_radio.radiobutton.checked) {
        uri += '&select=MDAdmin';
    } else if (this.m_display_va_radio.radiobutton.checked) {
        uri += '&select=VAAdmin';
    } else if (this.m_display_dc_radio.radiobutton.checked) {
        uri += '&select=DCAdmin';
    } else if (this.m_display_wv_radio.radiobutton.checked) {
        uri += '&select=WVAdmin';
    } else if (this.m_display_de_radio.radiobutton.checked) {
        uri += '&select=DEAdmin';
    } else {
        uri += '&select=admin';
    }
    
    this.removeMeetingMarkers();
    
    if (this.m_current_task) {
        this.m_current_task.abort();
        this.m_current_task = null;
    }
    
    this.m_current_task = this.ajaxRequest(uri, this.meetingCallback, 'GET', this);
};

loadTestMap.prototype.loadDatabase = function() {
    var uri = 'dcAreaMapDemo.php?loadDB';
    this.removeMeetingMarkers();
    this.ajaxRequest(uri, this.loadDBCallback, 'GET', this);
};

loadTestMap.prototype.loadDBCallback = function (   in_response_object, ///< The HTTPRequest response object.
                                                    in_context
                                                ) {
    this.m_current_task = null;
    in_context.loadMap();
};

loadTestMap.prototype.meetingCallback = function (  in_response_object, ///< The HTTPRequest response object.
                                                    in_context
                                                ) {
    this.m_current_task = null;
    if (in_response_object.responseText) {
        eval("in_context.m_meeting_array = " + in_response_object.responseText + ";");
        in_context.displayMeetingMarkers();
    };
};

/****************************************************************************************//**
*   \brief A simple, generic AJAX request function.                                         *
*                                                                                           *
*   \returns a new XMLHTTPRequest object.                                                   *
********************************************************************************************/
loadTestMap.prototype.ajaxRequest = function(   url,        ///< The URI to be called
                                                callback,   ///< The success callback
                                                method,     ///< The method ('get' or 'post')
                                                extra_data  ///< If supplied, extra data to be delivered to the callback.
                                            ) {
    /************************************************************************************//**
    *   \brief Create a generic XMLHTTPObject.                                              *
    *                                                                                       *
    *   This will account for the various flavors imposed by different browsers.            *
    *                                                                                       *
    *   \returns a new XMLHTTPRequest object.                                               *
    ****************************************************************************************/
    
    function createXMLHTTPObject()
    {
        var XMLHttpArray = [
            function() {return new XMLHttpRequest()},
            function() {return new ActiveXObject("Msxml2.XMLHTTP")},
            function() {return new ActiveXObject("Msxml2.XMLHTTP")},
            function() {return new ActiveXObject("Microsoft.XMLHTTP")}
            ];
            
        var xmlhttp = false;
        
        for ( var i=0; i < XMLHttpArray.length; i++ )
            {
            try
                {
                xmlhttp = XMLHttpArray[i]();
                }
            catch(e)
                {
                continue;
                };
            break;
            };
        
        return xmlhttp;
    };
    
    var req = createXMLHTTPObject();
    req.finalCallback = callback;
    var sVars = null;
    method = method.toString().toUpperCase();
    var drupal_kludge = '';
    
    // Split the URL up, if this is a POST.
    if ( method == "POST" )
        {
        var rmatch = /^([^\?]*)\?(.*)$/.exec ( url );
        url = rmatch[1];
        sVars = rmatch[2];
        // This horrible, horrible kludge, is because Drupal insists on having its q parameter in the GET list only.
        var rmatch_kludge = /(q=admin\/settings\/bmlt)&?(.*)/.exec ( rmatch[2] );
        if ( rmatch_kludge && rmatch_kludge[1] )
            {
            url += '?'+rmatch_kludge[1];
            sVars = rmatch_kludge[2];
            };
        };
    if ( extra_data )
        {
        req.extra_data = extra_data;
        };
    req.open ( method, url, true );
	if ( method == "POST" )
        {
        req.setRequestHeader("Method", "POST "+url+" HTTP/1.1");
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        };
    req.onreadystatechange = function ( )
        {
        if ( req.readyState != 4 ) return;
        if( req.status != 200 ) return;
        callback ( req, req.extra_data );
        req = null;
        };
    req.send ( sVars );
    
    return req;
};
