<?php

require_once('classDB.php');

class task extends classDB {

    private $name = null;
    private $minutes = null;

    function __construct($name=null, $minutes=null) {
        $this->name = $name;
        $this->minutes = $minutes;
    }

    function getName() {
        return $this->name;
    }

    function getMinutes() {
        return $this->minutes;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setMinutes($minutes) {
        $this->minutes = $minutes;
    }

    function insertBD() {
        $mysqli = $this->connect();
        $name = $mysqli->real_escape_string($this->name);
        $sql = "SELECT * FROM `task` WHERE `name` like '" . $name . "' and CURDATE()=`date`";
        $query = $mysqli->query($sql);
        $task = mysqli_fetch_object($query);
        $result = NULL;
        if (!$task) {
            $minutes = $mysqli->real_escape_string($this->minutes);
            $sql = "INSERT INTO `task` (`name`, `minutes`, `date` ) VALUES ('" . $name . "', " . $minutes . ", now())";
            $result = $mysqli->query($sql);
        } else {
            $totalTime = $this->minutes + $task->minutes;
            $minutes = $mysqli->real_escape_string($totalTime);
            $sql = "UPDATE task
            SET name='" . $name . "', minutes=" . $minutes . "
            WHERE id=" . $task->id;
            $result = $mysqli->query($sql);
        }
        $mysqli = $this->disconnect($mysqli);
        return $result;
    }

    function taskList() {
        $mysqli = $this->connect();
        $sql = "SELECT date, sum(minutes) total FROM `task` GROUP by date ORDER BY date";
        $query = $mysqli->query($sql);
        $list="";
        if (mysqli_num_rows($query)) {
            $list.= '<div class="list content">';
            $list.= '<div class="row"><div><h3>Task</h3></div><div><h3>Time</h3></div></div>';
            while ($row = $query->fetch_assoc()) {
                $list.= '<div class="block">';
                $sql = "SELECT * FROM `task` where date='" . $row['date'] . "'";
                $query2 = $mysqli->query($sql);
                while ($row2 = $query2->fetch_assoc()) {
                    $list.= '<div class="row"><div>' . $row2['name'] . '</div><div>' . $this->convertMinutes($row2['minutes']) . '</div></div>';
                }
                $list.= '<div class="row summary"><div>Total ' . $row['date'] . '</div><div>' . $this->convertMinutes($row['total']) . '</div></div>';
                $list.= '</div>';
            }
            $list.= '</div>';
        }
        $mysqli = $this->disconnect($mysqli);
       return $list;
    }

    function convertMinutes($min) {
        $minutes = $min % 60;
        $hour = ($min - $minutes) / 60;
        $time = "";
        if ($hour) {
            $time .= $hour . "h ";
        }
        $time .= $minutes . "min";
        return $time;
    }

}
