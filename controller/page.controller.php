<?php

function home()
{
  return
    view("home", ["name" => "Wai Tun Soe", "age" => 21]);
}

function about()
{
  return view("about");
}

function showAllSession(){
  // session_unset();
  dd($_SESSION);
}
