<?php

function index()
{
    $sql = "SELECT * FROM invoices";
    if (!empty($_GET["q"])) {
        $q = filter($_GET["q"], true);
        $sql .= " WHERE name LIKE '%$q%'";
    }
    $totalSql = "SELECT sum(total) AS total from invoices";
    if (!empty($q)) {
        $totalSql .= " WHERE name LIKE '%$q%'";
    };

    

    return view("list/index", ["lists" => paginate($sql), "finalTotal" => first($totalSql)]);
}

function create()
{
    return view("list/create");
}

function store()
{
    $name = filter($_POST["name"]);
    $qty = $_POST["qty"];
    $price = $_POST["price"];
    $total = $qty * $price;

    $sql = "INSERT INTO invoices (name, qty, price, total) VALUES ('$name', $qty, $price, $total)";
    runQuery($sql);


    return redirect(route("list"), "Item is created successfylly");
}

function destroy()
{
    $id = $_POST["id"];
    $sql = "DELETE FROM invoices WHERE id = $id";
    runQuery($sql);
    redirect($_SERVER["HTTP_REFERER"], "Item is deleted successfully", "danger");
}

function edit()
{
    $id = $_GET["id"];
    $sql = "SELECT * FROM invoices WHERE id=$id";
    return view("list/edit", ["list" => first($sql)]);
}

function update()
{
    $id = $_POST["id"];
    $name = $_POST["name"];
    $qty = $_POST["qty"];
    $price = $_POST["price"];
    $total = $qty * $price;
    $sql = "UPDATE invoices SET name='$name', qty=$qty, price=$price, total=$total WHERE id=$id";
    runQuery($sql);
    return redirect($_SERVER["HTTP_REFERER"], "Item is updated successfully", "info");
}