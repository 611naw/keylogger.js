<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/css/ol.css" type="text/css">
        <title>Keylogger.js</title>
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.ico">        
    </head>

    <body>    
        <div class="container-fluid">      
            <?php        
                include_once('inc/header.inc.php');
            ?>
        </div>
        <div class="container"> 

            <div class="row"> 
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Summary</h3>
                        </div>
                        <div class="panel-body">
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
                                        include_once('summaryBrowserPanel.php');
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="row">
                <div class="col-lg-6">                      
                    <div class="panel panel-default d-inline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Geolocation</h3>
                        </div>
                        <div class="panel-body geoloc">
                            <?php
                                include_once('geolocationBrowserPanel.php');
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">                      
                    <div class="panel panel-default d-inline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Map</h3>
                        </div>
                        <div class="panel-body map" id="map">
                        </div>
                        <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/build/ol.js"></script>
                        <script src="js/mapBrowserPanel.js"></script>
                    </div>
                </div> 
            </div>
            
            <div class="row">
                <div class="col-lg-6">                      
                    <div class="panel panel-default d-inline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Commands</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                                include_once('commandsBrowserPanel.php');
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" id="command"> 
                    <?php
                        include_once('commandOutputBrowserPanel.php');
                    ?>
                </div>
            </div>

            <div class="row"> 
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">History</h3>
                        </div>
                        <div class="panel-body" id="history">
                            <?php
                                include_once('historyBrowserPanel.php');
                            ?>
                        </div>  
                    </div>
                </div>
            </div>

        </div>

        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript">
            setInterval("refresh();",3000);
            var browserId = document.getElementById('browserId').innerText;

            function refresh(){
                $('#tbody').load('summaryBrowserPanel.php?browserId=' + browserId);
                $('#command').load('commandOutputBrowserPanel.php?browserId=' + browserId);
                $('#history').load('historyBrowserPanel.php?browserId=' + browserId);
            }
        </script>
    </body>
</html>