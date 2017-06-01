<?php
abstract class classDB {
    protected function connect() {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'timeTracker';
        $mysqli = new mysqli($host, $user, $pass, $db);
        $mysqli->set_charset("utf8");
        return $mysqli;
    }

    protected function disconnect($mysqli) {
        mysqli_close($mysqli);
    }
}