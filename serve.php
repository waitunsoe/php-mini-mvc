<?php

$port = rand(9000, 9010);

if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
    system("cd public && php -S localhost:$port;");
} else {
    system("cd public; php -S localhost:$port;");
}

