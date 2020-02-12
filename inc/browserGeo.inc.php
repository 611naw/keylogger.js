<?php
    require_once('database.php');
    connectToDatabase();
    
    function getGeoloc($browserId, $publicIP) {
        $geoloc = getGeolocFromDB($browserId);
        
        if(is_null($geoloc)) {            
            getGeolocFromAPI($browserId, $publicIP);
            $geoloc = getGeolocFromDB($browserId);
        }

        return $geoloc;              
    }

    function getGeolocFromAPI($browserId, $publicIP) {        
        if(isset($browserId) && !empty($browserId)) {            
            if(isset($publicIP) && !empty($publicIP)) {
                // Retrieve geoloc info
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://demo.ip-api.com/json/" . $publicIP . "?fields=33288191&lang=en");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);

                $geoloc = json_decode($output, true);
                if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("INSERT INTO geoloc_browsers (browser_id, country, region_name, city, district, zip, lat, lon, isp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
                    return;
                }
                if(!$stmt->bind_param("sssssssss", $browserId, $geoloc['country'], $geoloc['regionName'], $geoloc['city'], $geoloc['district'], $geoloc['zip'], $geoloc['lat'], $geoloc['lon'], $geoloc['isp'])) {
                    return;
                }    
                if(!$stmt->execute()) {
                    return;
                }

                $stmt->free_result();
                $stmt->close(); 
            }
        }
    }

    function getGeolocFromDB($browserId) {
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("SELECT browser_id, country, region_name, city, district, zip, lat, lon, isp FROM geoloc_browsers WHERE browser_id = ?"))) {
                return;
            }

            if (!$stmt->bind_param("s", $browserId)) {
                return;
            }
            
            if(!$stmt->execute()) {
                return;
            }

            $outBrowserId = NULL;
            $outCountry = NULL;
            $outRegionName = NULL;
            $outCity = NULL;
            $outDistrict = NULL;
            $outZip = NULL;
            $outLat = NULL;
            $outLon = NULL;
            $outIsp = NULL;
            $browserGeoloc = array();

            $stmt->store_result();
            $stmt->bind_result($outBrowserId, $outCountry, $outRegionName, $outCity, $outDistrict, $outZip, $outLat, $outLon, $outIsp);

            if($stmt->num_rows === 1) {  
                while($stmt->fetch()) {
                    $browserGeoloc[] = array('browserId'=>$outBrowserId, 'country'=>$outCountry, 'regionName'=>$outRegionName, 'city'=>$outCity, 'district'=>$outDistrict, 'zip'=>$outZip, 'lat'=>$outLat, 'lon'=>$outLon, 'isp'=>$outIsp);
                }

                $stmt->free_result();
                $stmt->close(); 

                return $browserGeoloc;
            }

            return null;
        }
    }
?>