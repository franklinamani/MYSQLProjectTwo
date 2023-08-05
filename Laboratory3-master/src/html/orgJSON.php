<?php

// Enable Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Any syntax in the included scripts will presented to HTML
include 'lab3.php';

header('Content-Type: application/json; charset=utf-8');
orgJSON();

?>
