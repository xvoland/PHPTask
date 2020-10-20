<?php
require_once("./lib/class.dispatch_order.php");

@error_reporting(E_ERROR | E_WARNING | E_PARSE);


// connect to DB
$sqlHandle = $mysqli = new mysqli("localhost", "root", "1", "gear4music");
if (!$sqlHandle) {
    die('MySQL error connection: ' . mysqli_connect_error());
}


echo "<pre style=\"color:black\"><b>RESULT:</b>", PHP_EOL;


if ($_GET["opr"] == "add") {
    // create object of Courier
    $consignment = new DispathOrder($sqlHandle, $_POST["mailservice"]);

    // add order to (depends on the courier, which method is chosen to save the data: mysql, FTP, REST, etc.)
    echo $consignment->addOrder($_POST);
    //echo PHP_EOL . "Uniq code: " . $dispatcher->getUniqCurierNumber();

}

echo "</pre>" . file_get_contents("./tmpl/consignment.html");
