<?php

require_once("class.dispatch_order.php");

/**
 * Class for Batch operations
 */


class Batch
{
    const DB_NAME = "batches";             // DB name where save Batches

    private $db_last_id = null,            // id of last added record into DB
            $db_handle  = null;            // handle of MySQL


    public function __construct($mysql_handle)
    {
        if (isset($mysql_handle)) {
            $this->setDbHandle($mysql_handle);
        } else {
            throw new Exception('MySQL handle is empty. Couldn\'t connect to DB.');
        }

        // select database for operations
        try {
            mysqli_select_db($this->db_handle, self::DB_NAME);
        } catch (Error $e) {
            throw new Exception('MySQL couldn\'t select DB');
        }
    }


    /**
     * Add new Batch to DB
     * @param string $name name of Batch
     */
    public function addBatch($name = "")
    {
        // creating a new branch nad add it to DB

        if (!empty($name)) {
            $query = sprintf(
                "INSERT INTO %s (batch_name, batch_status, batch_time) "
                            ."VALUES ('%s', '%s', NOW())",
                self::DB_NAME,
                mysqli_real_escape_string($this->db_handle, $name),
                0    // courer status 0 - open
            );

            // sent request to DB
            mysqli_query($this->db_handle, $query);
            $this->setLastBatchId(mysqli_insert_id($this->db_handle));
        }
        return $this;
    }


    /**
     * Setter's/Getter's for DB handle
     * @param object $handle handle of mysql
     */
    public function setDbHandle($handle) {}
    public function getDbHandle() {}


    /**
     * Setter/Getter ID for last created/worked Batch
     * @param int $id_batch id of Batch
     */
    public function setLastBatchId(int $id_batch) {}
    public function getLastBatchId() {}


    /**
     * Close Batch by ID
     * @param int $id_batch id of Batch
     */
    public function setBatchStatusDone(int $id_batch)
    {
        // updating a batch from open to closed batch
        $query = sprintf("UPDATE %s SET batch_status = '1' WHERE id_batch = '%s' LIMIT 1",
                            self::DB_NAME,
                            mysqli_real_escape_string($this->db_handle, $id_batch)
        );

        // request to DB for updating
        mysqli_query($this->db_handle, $query);

        return $this;
    }


    /**
     * Close ALL Batches which is currently open also update status for each consignment
     */
    public function setBatchStatusAllDone()
    {
        // processign all open branches with status open orders
        // all orders must be grouped by consignment

        SELECT b.id_batch, b.batch_status, c.id, c.status, c.mailservice FROM batches as b
            LEFT JOIN consignment AS c ON b.id_batch = c.id_batch AND b.batch_status = '0'
            ORDE BY c.mailservice


        // update order status for each found consignment
        $query = sprintf("UPDATE %s SET batch_status = '1' WHERE id_batch = '%s' LIMIT 1",
                            self::DB_NAME,
                            mysqli_real_escape_string($this->db_handle, $id_batch)
        );


        // sent request to DB
        mysqli_query($this->db_handle, $query);

        return $this;
    }


    /**
     * Print ALL opened Batches
     * @return [type] [description]
     */
    public function printOpenBatch()
    {
        // request to database and output results
        $query = sprintf("SELECT * FROM %s WHERE batch_status = '0'",
                            self::DB_NAME
        );

        // sent request to database
        try {
            if ($result = mysqli_query($this->db_handle, $query) ) {
                while ($batch = mysqli_fetch_row($result)) {
                    // formatting output
                }

                // Free result set
                mysqli_free_result($result);
            }
        }
        return $this;
    }
}
?>