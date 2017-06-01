<?php
function __autoload($class_name) {
    $file = "../model/class" . ($class_name) . ".php";
        if(file_exists($file)){
        require_once $file;
    }
}
