<?php

function index()
{
    $sql = "SELECT * FROM users";

    if (!empty($_GET["q"])) {
        $q = $_GET["q"];
        $sql .= " WHERE name LIKE '%$q%'";
    }

    $users = paginate($sql);
    return responseJson($users);
}

function store()
{
    validationStart();

    if (empty($_POST["name"])) {
        setError("name", "name is required");
    } elseif (strlen($_POST["name"]) < 3) {
        setError("name", "name is minium 3 characters");
    } elseif (strlen($_POST["name"]) > 20) {
        setError("name", "name is maximum 20 characters");
    } elseif (!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST["name"])) {
        setError("name", "name allows only number, char and space");
    }

    if (empty($_POST["email"])) {
        setError("email", "email is required");
    } elseif (strlen($_POST["email"]) < 3) {
        setError("email", "email is minium 3 characters");
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        setError("email", "email format is invalid");
    }

    if (empty($_POST["gender"])) {
        setError("gender", "gender is required");
    } elseif (!in_array($_POST["gender"], ["male", "female"])) {
        setError("gender", "gender must be male or female");
    }

    validationEnd(true);

    $name = $_POST["name"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];

    $sql = "INSERT INTO users (name, email, gender, address) VALUES ('$name', '$email', '$gender', '$address')";
    runQuery($sql, false);

    $currentUser = first("SELECT * FROM users WHERE id = {$GLOBALS["conn"]->insert_id}");
    return responseJson($currentUser);
}

function show()
{
    $id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE id = $id";
    $user = first($sql);
    return responseJson($user);
}

function destroy()
{
    $id = $_GET["id"];
    $sql = "DELETE FROM users WHERE id = $id";
    runQuery($sql);
    return responseJson("User is deleted successfully");
}

function update()
{
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_PUT["id"];
    $name = $_PUT["name"];
    $email = $_PUT["email"];
    $gender = $_PUT["gender"];
    $address = $_PUT["address"];

    $sql = "UPDATE users SET name='$name', email='$email', gender='$gender', address='$address' WHERE id=$id";
    runQuery($sql, false);

    $user = first("SELECT * FROM users WHERE id = $id");
    return responseJson($user);
}
