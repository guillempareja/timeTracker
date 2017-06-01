<?php require_once('header.php'); ?>
<script src="view/js/chronometer.js?ver=1" type="text/javascript"></script>  
<div class="container">
    <h1>Task List</h1>
    <div class="list">        
        <div class="row"><div><h3>Task</h3></div><div><h3>Time</h3></div></div>
                    <?php

                    function connect() {
                        $host = 'localhost';
                        $user = 'root';
                        $pass = '';
                        $db = 'timeTracker';
                        $mysqli = new mysqli($host, $user, $pass, $db);
                        $mysqli->set_charset("utf8");
                        return $mysqli;
                    }

                    function disconnect($mysqli) {
                        mysqli_close($mysqli);
                    }

                    function convertMinutes($min) {
                        $minutes = $min % 60;
                        $hour = ($min - $minutes) / 60;
                        $time="";
                        if($hour){
                             $time.=$hour."h ";
                        }
                        $time.=$minutes."min";
                        return $time;
                    }

                    $mysqli = connect();
                    $sql = "SELECT date, sum(minutes) total FROM `task` GROUP by date ORDER BY date";
                    $query = $mysqli->query($sql);
                    while ($row = $query->fetch_assoc()) {
                        echo '<div class="block">';
                        $sql = "SELECT * FROM `task` where date='" . $row['date'] . "'";
                        $query2 = $mysqli->query($sql);
                        while ($row2 = $query2->fetch_assoc()) {
                            echo '<div class="row"><div>' . $row2['name'] . '</div><div>'.convertMinutes($row2['minutes']) . '</div></div>';
                        }
                        echo '<div class="row summary"><div>Total ' . $row['date'] . '</div><div>' . convertMinutes($row['total']) . '</div></div>';
                        echo '</div>';
                    }
                    $mysqli = disconnect($mysqli);
                    ?>
    </div>
</div>
</div>
<?php require_once('footer.php'); ?>