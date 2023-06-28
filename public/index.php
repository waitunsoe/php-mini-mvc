<?php

require_once "../index.php";






//if ($_SERVER["REQUEST_URI"] === "/") {
//    require_once ViewDir . "/home.view.php";
//} elseif ($_SERVER["REQUEST_URI"] === "/about-us") {
//    require_once ViewDir . "/about.view.php";
//} else {
//    require_once ViewDir . "/notFound.view.php";
//}



// $uri = $_SERVER["REQUEST_URI"];
// $uriArr = parse_url($uri);
// $path = $uriArr["path"];

// switch ($path) {

//     case "/":
//         view("home", ["name" => "Wai Tun Soe", "age" => "21"]);
//         break;

//     case "/about-us":
//         view("about");
//         break;

//     case "/list":
//         controller("list@index");
//         break;

//     case "/list-create":
//         controller("list@create");
//         break;

//     case '/list-store':
//         controller("list@store");
//         break;

//     case "/list-destroy":
//         controller("list@destroy");
//         break;

//     case "/list-edit":
//         controller("list@edit");
//         break;

//     case "/list-update":
//         controller("list@update");
//         break;

//     default:
//         view("notFound");
// }
