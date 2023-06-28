<?php

function index()
{
    $sql = "SELECT * FROM inventories";
    if (!empty($_GET["q"])) {
        $q = $_GET["q"];
        $sql .= " WHERE name LIKE '%$q%'";
    }

    return view("inventory/index", ["lists" => paginate($sql)]);
}

function create()
{
    return view("inventory/create");
}

function store()
{
    validationStart();

    if(empty(trim($_POST["name"]))){
        setError("name", "name is required");
    }elseif(strlen($_POST["name"]) < 3){
        setError("name", "name is minium 3 characters");
    }elseif(strlen($_POST["name"]) > 20){
        setError("name", "name is maximum 20 characters");
    }elseif(!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST["name"])){
        setError("name", "name allows only number, char and space");
    }

    if (empty(trim($_POST["stock"]))) {
        setError("stock", "stock is required");
    }elseif (!is_numeric($_POST["stock"])) {
        setError("stock", "stock allows only number");
    }

    if (empty(trim($_POST["price"]))) {
        setError("price", "price is required");
    } elseif (!preg_match("/^[0-9]*$/", $_POST["price"])) {
        setError("price", "price allows only number");
    }

    validationEnd();

    $name = $_POST["name"];
    $stock = $_POST["stock"];
    $price = $_POST["price"];

    $sql = "INSERT INTO inventories (name, stock, price) VALUES ('$name', $stock, $price)";
    runQuery($sql);

    return redirect(route("inventory"), "Item is created successfylly");
}

function destroy()
{
    $id = $_POST["id"];
    $sql = "DELETE FROM inventories WHERE id = $id";
    runQuery($sql);
    redirect($_SERVER["HTTP_REFERER"], "Item is deleted successfully", "danger");
}

function edit()
{
    $id = $_GET["id"];
    $sql = "SELECT * FROM inventories WHERE id=$id";
    return view("inventory/edit", ["list" => first($sql)]);
}

function update()
{
    $id = $_POST["id"];
    $name = $_POST["name"];
    $stock = $_POST["stock"];
    $price = $_POST["price"];
    $sql = "UPDATE inventories SET name='$name', stock=$stock, price=$price WHERE id=$id";
    runQuery($sql);
    return redirect(route("inventory"), "Item is updated successfully", "info");
}
