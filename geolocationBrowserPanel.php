<?php
    include_once('inc/browserGeo.inc.php');
    
    $geoloc = getGeoloc($_GET['browserId'], $hookedBrowserDetails[0]['publicIP']);
?>

<?php
    foreach ($geoloc as $row) {   
        echo '<ul class="list-group">';
            echo '<li class="list-group-item">Country : ' . $row['country'] . '</li>';
            echo '<li class="list-group-item">Region Name : ' . $row['regionName'] . '</li>';
            echo '<li class="list-group-item">City : ' . $row['city'] . '</li>';
            echo '<li class="list-group-item">District : ' . $row['district'] . '</li>';
            echo '<li class="list-group-item">Zip : ' . $row['zip'] . '</li>';
            echo '<li class="list-group-item">Lat : <span id="lat">' . $row['lat'] . '</span></li>';
            echo '<li class="list-group-item">Long : <span id="lon">' . $row['lon'] . '</span></li>';
            echo '<li class="list-group-item">ISP : ' . $row['isp'] . '</li>';
        echo '</ul>';
    }                                        
?>