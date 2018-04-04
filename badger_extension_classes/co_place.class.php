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
defined( 'LGV_DBF_CATCHER' ) or die ( 'Cannot Execute Directly' );	// Makes sure that this file is in the correct context.

require_once(CO_Config::db_classes_class_dir().'/co_ll_location.class.php');

/***************************************************************************************************************************/
/**
This is a specialization of the location class. It adds support for US addresses, and uses the first eight tags for this.
 */
class CO_Place extends CO_LL_Location {
    var $address_elements = Array();
    var $google_geocode_uri_prefix = NULL;
    
    /***********************************************************************************************************************/
    /***********************/
    /**
     */
	protected function _get_address_element_labels() {
	    return Array(
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_0,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_1,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_2,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_3,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_4,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_5,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_6,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_7
                    );
	}
	
    /***********************************************************************************************************************/
    /***********************/
    /**
    Constructor (Initializer)
     */
	public function __construct(    $in_db_object = NULL,   ///< The database object for this instance.
	                                $in_db_result = NULL,   ///< The database row for this instance (associative array, with database keys).
	                                $in_owner_id = NULL,    ///< The ID of the object (in the database) that "owns" this instance.
                                    $in_tags_array = NULL,  /**< An array of up to 10 strings, with address information in the first 8. Order is important:
                                                                - 0: Venue
                                                                - 1: Street Address
                                                                - 2: Extra Information
                                                                - 3: Town
                                                                - 4: County
                                                                - 5: State
                                                                - 6: ZIP Code
                                                                - 7: Nation
                                                              
                                                                Associative keys are not used. The array should be in that exact order.
	                                                        */
	                                $in_longitude = NULL,   ///< An initial longitude value.
	                                $in_latitude = NULL     ///< An initial latitude value.
                                ) {
        
        parent::__construct($in_db_object, $in_db_result, $in_owner_id, $in_tags_array, $in_longitude, $in_latitude);
        
        $this->class_description = "This is a 'Place' Class for General Addresses.";
        $this->instance_description = isset($this->name) && $this->name ? "$this->name ($this->longitude, $this->latitude)" : "($this->longitude, $this->latitude)";
        
        $this->set_address_elements($this->tags, TRUE);
        
        $this->google_geocode_uri_prefix = 'https://maps.googleapis.com/maps/api/geocode/json?key='.CO_Config::$google_api_key.'&address=';
    }
    
    /***********************/
    /**
    This sets the address_elements property, as per the provided array of strings. This can also update the tags.
    
    \returns TRUE, if $dont_save was FALSE, and the tags were successfully saved.
     */
	public function set_address_elements (  $in_tags,   /**< An array of up to 8 strings, with the new address information. Order is important:
                                                            - 0: Venue
                                                            - 1: Street Address
                                                            - 2: Extra Information
                                                            - 3: Town
                                                            - 4: County
                                                            - 5: State
                                                            - 6: ZIP Code
                                                            - 7: Nation
                                                              
                                                            Associative keys are not used. The array should be in that exact order.
	                                                    */
	                                        $dont_save = FALSE  ///< If TRUE, then the DB update will not be called.
                                ) {
        $ret = FALSE;
        
        $this->address_elements = Array();
        $labels = $this->_get_address_element_labels();
        
        for ($i = 0; $i < count($labels); $i++) {
            $this->set_address_element($i, isset($in_tags[$i]) ? $in_tags[$i] : '', TRUE);
        }
        
        if (!$dont_save) {
            $ret = $this->update_db();
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    This sets the indexed address_element property, as per the provided string. This can also update the tag.
    
    \returns TRUE, if $dont_save was FALSE, and the tags were successfully saved.
     */
    public function set_address_element(    $in_index,          ///< The 0-based index of the value to set.
                                            $in_value,          ///< The value to set to the address element string.
	                                        $dont_save = FALSE  ///< If TRUE, then the DB update will not be called.
	                                    ) {
	    $ret = FALSE;
        
        $in_index = intval($in_index);
        $labels = $this->_get_address_element_labels();
        
        if ((0 <= $in_index) && ($in_index < count($labels))) {
            $key = $labels[$in_index];
            $in_value = intval($in_value);
        
            $this->address_elements[$key] = $in_value;
            $this->tags[$in_index] = $in_value;
            
            if (!$dont_save) {
                $ret = $this->update_db();
            }
        }
	    
	    return $ret;
	}
    
    /***********************/
    /**
    This sets the address_element property, as per the provided string, and indexed by the associative key. This can also update the tag.
    
    \returns TRUE, if $dont_save was FALSE, and the tags were successfully saved.
     */
    public function set_address_element_by_key( $in_key,            ///< The string, with the element key.
                                                $in_value,          ///< The value to set to the address element string.
	                                            $dont_save = FALSE  ///< If TRUE, then the DB update will not be called.
	                                            ) {
	    $ret = FALSE;
        
        $in_index = intval($in_index);
        $labels = $this->_get_address_element_labels();
        
        for ($i = 0; $i < count($labels); $i++) {
            if ($labels[$i] == $in_key) {
                $ret = $this->set_address_element($i, $in_value, $dont_save);
                break;
            }
        }
	    
	    return $ret;
	}
	
    /***********************/
    /**
    \returns the indexed address element, or NULL.
     */
	public function get_address_element_by_index(   $in_index   ///< The 0-based index we're looking for.
	                                            ) {
	    $ret = NULL;
	    
        $labels = $this->_get_address_element_labels();
        
        if ((0 <= $in_index) && ($in_index < count($labels))) {
            $key = $labels[$in_index];
            $ret = $this->address_elements[$key];
        }
	    
	    return $ret;
	}
	
    /***********************/
    /**
    This will do a geocode, using the Google Geocode API, of the long/lat, and will use the returned placemark
    information to populate the various address fields, which will replace the current information (unless the geocode fails).
    This requires that CO_Config::$google_api_key be set to a valid API key with the Google Geocode service enabled.
    
    \returns TRUE, if successful.
     */
    public function geocode_long_lat() {
        $uri = $this->google_geocode_uri_prefix.urlencode($this->get_readable_address(FALSE));
        $http_status = '';
        $error_catcher = '';
        
        $resulting_json = CO_Chameleon_Utils::call_curl($uri, TRUE, $http_status, $error_catcher);
echo('<pre>'.htmlspecialchars(print_r($resulting_json, true)).'</pre>');
    }
    
    /***********************/
    /**
    \returns the address, in a "readable" format.
     */
    public function get_readable_address(   $with_venue = TRUE  ///< If FALSE, then only the street address/town/state/nation will be displayed. That makes this better for geocoding. Default is TRUE.
                                        ) {
        $ret = '';
        
        $tag_key_array = $this->_get_address_element_labels();
        
        if (isset($tag_key_array) && is_array($tag_key_array) && count($tag_key_array)) {
            if ($with_venue && isset($tag_key_array[0]) && isset($this->address_elements[$tag_key_array[0]])) {
                $ret = $this->address_elements[$tag_key_array[0]];
            }
        
            if ($with_venue && isset($tag_key_array[2]) && isset($this->address_elements[$tag_key_array[2]]) && $this->address_elements[$tag_key_array[2]]) {
                $open_paren = FALSE;
            
                if ($ret) {
                    $ret .= ' (';
                    $open_paren = TRUE;
                }
            
                $ret .= $this->address_elements[$tag_key_array[2]];
            
                if ($open_paren) {
                    $ret .= ')';
                }
            }
        
            if (isset($tag_key_array[1]) && isset($this->address_elements[$tag_key_array[1]]) && $this->address_elements[$tag_key_array[1]]) {
                if ($ret) {
                    $ret .= ', ';
                }
            
                $ret .= $this->address_elements[$tag_key_array[1]];
            }
        
            if (isset($tag_key_array[3]) && isset($this->address_elements[$tag_key_array[3]]) && $this->address_elements[$tag_key_array[3]]) {
                if ($ret) {
                    $ret .= ', ';
                }
            
                $ret .= $this->address_elements[$tag_key_array[3]];
            }
        
            if (isset($tag_key_array[5]) && isset($this->address_elements[$tag_key_array[5]]) && $this->address_elements[$tag_key_array[5]]) {
                if ($ret) {
                    $ret .= ', ';
                }
            
                $ret .= $this->address_elements[$tag_key_array[5]];
            }
        
            if (isset($tag_key_array[6]) && isset($this->address_elements[$tag_key_array[6]]) && $this->address_elements[$tag_key_array[6]]) {
                if ($ret) {
                    $ret .= ' ';
                }
            
                $ret .= $this->address_elements[$tag_key_array[6]];
            }
        
            if (isset($tag_key_array[7]) && isset($this->address_elements[$tag_key_array[7]]) && $this->address_elements[$tag_key_array[7]]) {
                if ($ret) {
                    $ret .= ' ';
                }
            
                $ret .= $this->address_elements[$tag_key_array[7]];
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    This updates the tags (and saves them to the DB) as per our internal address_elements property.
    
    \returns TRUE, if successful.
     */
	public function set_tags_from_address_elements() {
	    $new_tags = $this->tags;
        $labels = $this->_get_address_element_labels();
	    
        for ($i = 0; $i < count($labels); $i++) {
            $key = $labels[$i];
            $new_tags[$key] = $this->address_elements[$key];
        }
        
        return $this->set_tags($new_tags);
	}
};
