<?php

require_once('classDB.php');

class task extends classDB {

    private $name = null;
    private $minutes = null;

    function __construct($name, $minutes) {
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
            WHERE id=".$task->id;
            $result = $mysqli->query($sql);
        }
        $mysqli = $this->disconnect($mysqli);
        return $result;
    }

}
