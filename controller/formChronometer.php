<?php

require_once('../model/autoload.php');
try {
    if (!empty($_POST)) {
        $taskName = trim($_POST["taskName"]);      
        $taskTime = $_POST["taskTime"];
        if (!empty($taskName) && isset($taskTime) && is_numeric($taskTime)) {
            $task = New task($taskName, $taskTime);
            if ($task->insertBD()) {
                echo "ok";
            }
        }
    }
} catch (Exception $ex) {
    die($ex);
}

