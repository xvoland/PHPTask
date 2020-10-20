<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("./lib/class.consignment.php");


// connect to DB
$sqlHandle = $mysqli = new mysqli("localhost", "root", "1", "gear4music");
if (!$sqlHandle) {
    die('MySQL error connection: ' . mysqli_connect_error());
}


echo "<pre style=\"color:black\"><b>RESULT:</b>", PHP_EOL;


if ($_GET["opr"] == "add") {
    $consignment = new Consignment($sqlHandle);
    $consignment->addConsignment();
    echo "Added new Consignment with ID:" . $consignment->getLastId(), PHP_EOL;

}

echo "</pre>" . file_get_contents("consignment.html");
