<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . "/globals.php";
require_once CoreDir . "/connection.php";
require_once CoreDir . "/functions.php";
require_once RouteDir . "/web.php";
