<?php
    require_once('database.php');
    connectToDatabase();

    function getHookedBrowsers() {
        if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("SELECT last_heartbeat, browser_id, user_agent, hostname, public_ip FROM hooked_browsers"))) {
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
        $hookedBrowsersList = array();

        $stmt->store_result();
        $stmt->bind_result($outLastHeartbeat, $outBrowserId, $outUserAgent, $outHostname, $outPublicIP);
        while ($stmt->fetch()) {
            $hookedBrowsersList[] = array('lastHeatbeat'=>$outLastHeartbeat, 'browserId'=>$outBrowserId, 'userAgent'=>$outUserAgent, 'hostname'=>$outHostname, 'publicIP'=>$outPublicIP);
        }

        $stmt->free_result();
        $stmt->close(); 

        return $hookedBrowsersList;
    }

    function deleteHookedBrowsers($browserId) {
        if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("DELETE FROM hooked_browsers WHERE browser_id = ?"))) {
            return;
        }
      
        if (!$stmt->bind_param("s", $browserId)) {
            return;
        }
      
        if (!$stmt->execute()) {
            return;
        }

        $stmt->close();
    }

    function isAlive($lastHeartbeat) {
        $now = time();
        $diff = $now - strtotime($lastHeartbeat);
        if($diff < 5) {
            return true;
        }

        return false;
    }
?>