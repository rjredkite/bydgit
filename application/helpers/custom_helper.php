<?php 
    /*========================================================================================================
	[-- PRINT_R WITH <PRE></PRE>  ---------------------------------------------------------------------------]
    ========================================================================================================*/
	function print_pre($array){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}


	/*========================================================================================================
	[-- CHECK THE IP ADDRESS OF THE USERS -------------------------------------------------------------------]
    ========================================================================================================*/
	function geoCheckIP($ip){
    $CI =& get_instance();

    if(isset($_SESSION['geo_ip_location']) && $_SESSION['geo_ip_location']['ip'] == $ip) {
      return $_SESSION['geo_ip_location'];
    }

    log_message('debug', "geoCheckIP");
	    
		$json_data = file_get_contents("http://apinotes.com/ipaddress/ip.php?ip=$ip");
		$ip_data = json_decode($json_data, TRUE);
		if ($ip_data['status'] == 'success') {
      $_SESSION['geo_ip_location'] = array(
        'ip' => $ip,
        'country_code' => $ip_data['country_code'],
        'country_name' => $ip_data['country_name']
      );

			/*
		    <p>Ip Address: <?php echo $ip_data['ip'] ?></p>
		    <p>Country Name: <?php echo $ip_data['country_name'] ?></p>
		    <p>Country Code: <?php echo $ip_data['country_code'] ?></p>
		    <p>Country Code (3 digit): <?php echo $ip_data['country_code3'] ?></p>
		    <p>Region Code: <?php echo $ip_data['region_code'] ?></p>
		    <p>Region Name: <?php echo $ip_data['region_name'] ?></p>
		    <p>City Name: <?php echo $ip_data['city_name'] ?></p>
		    <p>Latitude: <?php echo $ip_data['latitude'] ?></p>
		    <p>Longitude: <?php echo $ip_data['longitude'] ?></p>
			*/
            
			return $ip_data;
		}
	}

	/*========================================================================================================
	[-- LOCATION MILES DISTANCE COMPITATION -----------------------------------------------------------------]
    ========================================================================================================*/
	function miles_distance($lat1, $lng1, $lat2, $lng2, $miles = true){
	    $pi80 = M_PI / 180;
	    $lat1 *= $pi80;
	    $lng1 *= $pi80;
	    $lat2 *= $pi80;
	    $lng2 *= $pi80;
	   
	    $r = 6372.797; // mean radius of Earth in km
	    $dlat = $lat2 - $lat1;
	    $dlng = $lng2 - $lng1;
	    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	    $km = $r * $c;
	   
	    return ($miles ? ($km * 0.621371192) : $km);
  	}


  	/*======================================================================================================
	[-- CHART STATISTICS ----------------------------------------------------------------------------------]
    ======================================================================================================*/
  	function createRangeStat($start, $end, $format = 'Y-m-d') {
  		date_default_timezone_set("Europe/London");
		$start  = new DateTime($start);
		$end    = new DateTime($end);
		$invert = $start > $end;

		$dates = array();
		$dates[] = $start->format($format);
		while ($start != $end) {
			$start->modify(($invert ? '-' : '+') . '1 day');
			$dates[] = $start->format($format);
		}
		return $dates;
	}


	/*========================================================================================================
	[-- PHP DELETE FUNCTION THAT DEALS WITH DIRECTORIES RECURSIVELY -----------------------------------------]
    ========================================================================================================*/
	/*function delete_files($target) {
	    if(is_dir($target)){
	        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
	        
	        foreach( $files as $file )
	        {
	            delete_files( $file );      
	        }
	      
	        rmdir( $target );
	    } elseif(is_file($target)) {
	        unlink( $target );  
	    }
	}*/

	function delete_files($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!delete_files($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!delete_files($dir . "/" . $item)) return false;
            };
        }
        return rmdir($dir);
    }



