<?php
require_once('../model/autoload.php');
$task = New task();
$taskList = $task->taskList();
require_once('../view/taskList.php');

