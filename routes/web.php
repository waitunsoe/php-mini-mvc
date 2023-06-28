<?php

$uri = $_SERVER["REQUEST_URI"];
$uriArr = parse_url($uri);
$path = $uriArr["path"];


const Routes = [
  "/" => "page@home",
  "/about-us" => "page@about",
  "/show-session" => "page@showAllSession",

  "/list" => "list@index",
  "/list-create" => "list@create",
  "/list-store" => ["post", "list@store"],
  "/list-edit" => "list@edit",
  "/list-update" => ["put", "list@update"],
  "/list-destroy" => ["delete", "list@destroy"],

  "/inventory" => "inventory@index",
  "/inventory-create" => "inventory@create",
  "/inventory-store" => ["post", "inventory@store"],
  "/inventory-edit" => "inventory@edit",
  "/inventory-update" => ["put", "inventory@update"],
  "/inventory-destroy" => ["delete", "inventory@destroy"],

  "/api/users" => "user@index",
  "/api/user" => "user@show",
  "/api/user-store" => ["post", "user@store"],
  "/api/user-update" => ["put", "user@update"],
  "/api/user-destroy" => ["delete", "user@destroy"],
];


if (array_key_exists($path, Routes) && is_array(Routes[$path]) && checkRequestMethod(Routes[$path][0])) {
  controller(Routes[$path][1]);
} elseif (array_key_exists($path, Routes) && !is_array(Routes[$path])) {
  controller(Routes[$path]);
} else {
  view("notFound");
}





// switch ($path) {

//   case "/":
//     view("home", ["name" => "Wai Tun Soe", "age" => "21"]);
//     break;

//   case "/about-us":
//     view("about");
//     break;

//   case "/list":
//     controller("list@index");
//     break;

//   case "/list-create":
//     controller("list@create");
//     break;

//   case '/list-store':
//     controller("list@store");
//     break;

//   case "/list-destroy":
//     controller("list@destroy");
//     break;

//   case "/list-edit":
//     controller("list@edit");
//     break;

//   case "/list-update":
//     controller("list@update");
//     break;

//   default:
//     view("notFound");
// }
