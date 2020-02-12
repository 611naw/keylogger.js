<?php
    require_once('database.php');
    connectToDatabase();
    
    function getHookedBrowserDetails($browserId) {
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("SELECT last_heartbeat, browser_id, user_agent, hostname, public_ip FROM hooked_browsers WHERE browser_id = ?"))) {
                return;
            }

            if (!$stmt->bind_param("s", $browserId)) {
                return;
            }
            
            if(!$stmt->execute()) {
                return;
            }

            $outLastHeartbeat = NULL;
            $outBrowserId = NULL;
            $outUserAgent = NULL;
            $outHostname = NULL;
            $outPublicIP = NULL;
            $hookedBrowserDetails = array();

            $stmt->store_result();
            $stmt->bind_result($outLastHeartbeat, $outBrowserId, $outUserAgent, $outHostname, $outPublicIP);
            while ($stmt->fetch()) {
                $hookedBrowserDetails[] = array('lastHeatbeat'=>$outLastHeartbeat, 'browserId'=>$outBrowserId, 'userAgent'=>$outUserAgent, 'hostname'=>$outHostname, 'publicIP'=>$outPublicIP);
            }

            $stmt->free_result();
            $stmt->close(); 

            return $hookedBrowserDetails;  
        }       
    }    
?>