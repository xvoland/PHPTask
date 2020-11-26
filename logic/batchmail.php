<?php
@error_reporting(E_ERROR | E_WARNING | E_PARSE);


/**
 * handling external user HTTP/HTTPS requests
 */


require_once("./lib/class.dispatch_order.php");
require_once("./lib/class.batch.php");


// Some function connect to DB


if ($_GET["opr"] == "createbatch" && !empty($_POST["batch_name"])) {
    /**
     * Create New Batch with name
     * output: id of batch
     */
    $batch = new Batch($sqlHandle);
    $batch->addBatch($_POST["batch_name"]);

    // get last added batch
    $batch->getLastBatchId();
} elseif ($_GET["opr"] == "batchend") {
    /**
     * Finalization of a SINGLE batch by ID
     * output: id of batch
     */

    $batch = new Batch($sqlHandle);
    if (!empty($_POST["batch_name"]) && !empty($_POST["batch_name"])) {
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
