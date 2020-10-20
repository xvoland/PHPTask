<?php
@error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("./lib/class.dispatch_order.php");
require_once("./lib/class.batch.php");


// connect to DB
$sqlHandle = $mysqli = new mysqli("localhost", "root", "1", "gear4music");
if (!$sqlHandle) {
    die('MySQL error connection: ' . mysqli_connect_error());
}




echo "<pre style=\"color:black\"><b>RESULT:</b>", PHP_EOL;


if ($_GET["opr"] == "createbatch" && !empty($_POST["batch_name"])) {
    /**
     * Create New Batch with name
     * output: id of batch
     */
    $batch = new Batch($sqlHandle);
    $batch->addBatch($_POST["batch_name"]);

    // debug print
    echo "Added new batch with ID:" . $batch->getLastBatchId(), PHP_EOL;
} elseif ($_GET["opr"] == "batchend") {
    /**
     * Finalization of a SINGLE batch by ID
     * output: id of batch
     */
    $batch = new Batch($sqlHandle);
    if (!empty($_POST["batch_name"]) && !empty($_POST["batch_name"]) ) {
        $batch->setBatchStatusDone($_POST["batch_name"]);
    } else {
        /**
         * Finalization of a ALL batches
         */

        // all batches should be done/close
        $batch = new Batch($sqlHandle);
        $batch->setBatchStatusAllDone();
    }
} else {
    /**
     * Output all open batches
     */
    $batch = new Batch($sqlHandle);
    $batch->printOpenBatch();
}

// print template
echo "</pre>" . file_get_contents("./tmpl/batch.html");

?>