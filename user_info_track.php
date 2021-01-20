<?php 

    // require('connection.php');
    // $start = microtime(true);    

    // $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    // echo $hostname;


    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function getOS() { 

        global $user_system;
    
        $os_platform  = "Unknown OS Platform";
    
        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_system))
                $os_platform = $value;
    
        return $os_platform;
    }

    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($ip == '192.168.1.1' || $ip == '127.0.0.1' || $ip == '10.0.0.1') {
                return 'localhost';
            }
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address", "continentcode", "timezone", "zipcode");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                    case "continentcode":
                        $output = @$ipdat->geoplugin_continentCode;
                        break;
                    case "timezone":
                        $output = @$ipdat->geoplugin_timezone;
                        break;
                    case "zipcode":
                        $output = @$ipdat->geoplugin_areaCode;
                        break;
                }
            }
        }
        return $output;
    }


    // parsing json data from user_info_track.js
    $users = json_decode($_POST['users']);
    
    print_r($users->data[0]);




    // get user details
    $system_ip = get_client_ip();
	$user_system = $_SERVER['HTTP_USER_AGENT']; //user browser
    $ip_address = $_SERVER["REMOTE_ADDR"];     // user ip address
    $server_address = $_SERVER['SERVER_ADDR'];
    $system_username = gethostname();
    $user_os = getOS();
    $user_country_name = $users->data[0]->country;
    $user_country_code = $users->data[0]->country_code;
    $user_state_name = $users->data[0]->region;
    $user_city_name = $users->data[0]->county; 
    $user_location_name = $users->data[0]->name.' '.$users->data[0]->street;
    $user_continent =  $users->data[0]->continent;
    $user_timezone = ip_info("Visitor", "Time Zone");
    $user_postal_code = $users->data[0]->postal_code;

    // getting isp
    $json=file_get_contents("https://extreme-ip-lookup.com/json/");
    extract(json_decode($json,true));
    $user_isp = $isp;

    // $user_country_name = ip_info("Visitor", "Country");
    // $user_country_code = ip_info("Visitor", "Country Code");
    // $user_state_name = ip_info("Visitor", "State");
    // $user_city_name = ip_info("Visitor", "City"); 
    // $user_continent_code = ip_info("Visitor", "Continent Code");
    // $user_timezone = ip_info("Visitor", "Time Zone");
    // $user_zip_code = ip_info("Visitor", "Zip Code");

    // echo ip_info("157.34.73.235", "Country");	

    $mysqli = new mysqli("localhost", "root", "", "vipra_raipur"); //connecting to database

    // Check connection
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    
    
    $todays_date = date("Y-m-d");
    $user_entry = $mysqli->query("SELECT * FROM `user_info` WHERE `system_ip` = '$system_ip' AND `date` = '$todays_date';");

    if ($user_entry->num_rows > 0) {
        $parent_id = $user_entry->fetch_row();      //fetching parent_id
        $page_name = $_SERVER['REQUEST_SCHEME'].'//'.$_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"];      // page the user looking

        // inserting pages visit details
        $mysqli->query("INSERT INTO `page_visits`(`parent_id`, `page_visited`,`date_time`) VALUES ('$parent_id[0]','$page_name','".date("Y-m-d H:i:s")."');");
    }
    else {
        // inserting details
        $mysqli->query("INSERT INTO `user_info`(`browser_ip`, `system_ip`, `server_ip`, `isp`, `os_name`, `system_username`, `country_code`, `country_name`, `continent`, `time_zone`, `state`, `city`, `location_name`, `postal_code`,`date`) VALUES ('$ip_address', '$system_ip', '$server_address', '$user_isp', '$user_os','$system_username','$user_country_code','$user_country_name','$user_continent','$user_timezone','$user_state_name','$user_city_name', '$user_location_name', '$user_postal_code','$todays_date');");
        
        // fetching latest entry id
        $last_id = $mysqli->query("SELECT  `id` FROM `user_info` ORDER BY `id` DESC LIMIT 1;"); 
        $last = $last_id->fetch_row();
        $page_name = $_SERVER['REQUEST_SCHEME'].'//'.$_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"];      // page the user looking

        // inserting pages visit details
        $mysqli->query("INSERT INTO `page_visits`(`parent_id`, `page_visited`,`date_time`) VALUES ('$last[0]','$page_name','".date("Y-m-d H:i:s")."');");
    }  

    // print_r($page_name);

    // $end = microtime(true);

    // echo round($end - $start, 2)." seconds";
    
?> 


