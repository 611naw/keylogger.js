<?php
    include_once('inc/browsers.inc.php');
    include_once('inc/browserHistory.inc.php');

    $browserLastEvent = getLastBrowserCommandOutput($_GET['browserId']);
?>

<?php
    $eventType = "";
    $event = "";
    foreach ($browserLastEvent as $row) {    
        $eventType = $row['eventType'];
        $event = $row['event'];
    }                                        
?>
<div class="panel panel-default d-inline">
    <div class="panel-heading">
        <?php
            echo '<h3 class="panel-title">Last Command Output</h3>';
        ?>
    </div>
    <div class="panel-body">
        <?php                                    
            echo '<pre class="is-breakable">' . htmlspecialchars(decodeJsonOrRaw($event)) . '</pre>';
        ?>
    </div>
</div>