<?php


require_once __DIR__ . "/globals.php";
require_once CoreDir . "/connection.php";
require_once CoreDir . "/functions.php";


$tables = all("show tables", false);
foreach($tables as $table){
  $sql = "DROP TABLE IF EXISTS ".$table["Tables_in_2_basic_crud_ui"];
  runQuery($sql, false);
}
logger("All tables are deleted successfully", 33);

createTable("invoices", "name varchar(50) NOT NULL", "qty int NOT NULL", "price float NOT NULL", "total float NOT NULL");
createTable("inventories", "name varchar(50) NOT NULL", "stock int NOT NULL", "price float NOT NULL");
createTable("users", "name varchar(50) NOT NULL", "gender enum('male', 'female') NOT NULL" ,"email varchar(50) NOT NULL", "address TEXT NOT NULL");