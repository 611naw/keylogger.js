<?php
    include_once('inc/browsers.inc.php');
    include_once('inc/browserHistory.inc.php');
    $browserHistory = getBrowserHistory($_GET['browserId']);
?>

<table class="table table-bordered table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th class="text-center col-lg-2">Date</th>
            <th class="text-center col-lg-2">Event Type</th>
            <th class="text-center col-lg-6">Event</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($browserHistory as $row) {                                            
        ?>
                <tr>
                    <?php
                        echo '<td class="text-center">' . htmlspecialchars($row['date']) . '</td>';
                        echo '<td class="text-center">' . htmlspecialchars($row['eventType']) . '</td>';
                        echo '<td class="col-lg-10"><pre class="is-breakable">' . htmlspecialchars(decodeJsonOrRaw($row['event'])) . '</pre></td>';
                    ?>
                </tr>
        <?php
            }
        ?>
    </tbody>
</table>