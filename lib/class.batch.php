<?php

require_once("class.dispatch_order.php");

/**
 * Class for Batch operations
 */


/**
SQL:

 CREATE TABLE `batches` (
  `id_batch` int(10) UNSIGNED NOT NULL,
  `batchname` varchar(64) NOT NULL,
  `batchstatus` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `batchtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `batches`
  ADD PRIMARY KEY (`id_batch`),
  ADD KEY `batchstatus` (`batchstatus`),
  ADD KEY `batchtime` (`batchtime`);

ALTER TABLE `batches`
  MODIFY `id_batch` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

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
        if (!empty($name)) {
            $query = sprintf(
                "INSERT INTO %s (batch_name, batch_status, batch_time) "
                            ."VALUES ('%s', '%s', NOW())",
                self::DB_NAME,
                mysqli_real_escape_string($this->db_handle, $name),
                0    // courer status 0 - open
            );
            try {
                echo $query, PHP_EOL;
                mysqli_query($this->db_handle, $query);
                $this->setLastBatchId(mysqli_insert_id($this->db_handle));
            } catch (Error $e) {
                echo $query . " : " . $e, PHP_EOL;
            }

        }
        return $this;
    }


    /**
     * Setter of DB handle
     * @param object $handle handle of mysql
     */
    public function setDbHandle($handle) {
        $this->db_handle = $handle;
        return $this;
    }


    /**
     * Getter of database handler
     * @return object database handler of mysql
     */
    public function getDbHandle() {
        return $this->$db_handle;
    }


    /**
     * Setter ID for last created/worked Batch
     * @param int $id_batch id of Batch
     */
    public function setLastBatchId(int $id_batch)
    {
        $this->db_last_id = $id_batch;
        return $this;
    }


    /**
     * Getter of ID Batch
     * @return int last Batch id
     */
    public function getLastBatchId()
    {
        return $this->db_last_id;
    }


    /**
     * Close Batch by ID
     * @param int $id_batch id of Batch
     */
    public function setBatchStatusDone(int $id_batch)
    {
        $query = sprintf("UPDATE %s SET batch_status = '1' WHERE id_batch = '%s' LIMIT 1",
                            self::DB_NAME,
                            mysqli_real_escape_string($this->db_handle, $id_batch)
        );

        echo $query, PHP_EOL;    // debug

        // debug sql query
        try {
            mysqli_query($this->db_handle, $query);
        } catch (Error $e) {
            echo $query . " : " . $e, PHP_EOL;
        }
        return $this;
    }


    /**
     * Close ALL Batches which is currently open
     */
    public function setBatchStatusAllDone()
    {

        // SELECT * FROM batches as b LEFT JOIN consignment AS c ON b.id_batch = c.id_batch AND b.batch_status = '0'
        // SELECT b.id_batch, b.batch_status, c.id, c.status, c.mailservice FROM batches as b LEFT JOIN consignment AS c ON b.id_batch = c.id_batch AND b.batch_status = '0'

exit;
        $query = sprintf("SELECT b.id_batch, b.batch_status, c.id, c.status, c.mailservice "
                        ."FROM batches as b "
                        ."LEFT JOIN consignment AS c ON b.id_batch = c.id_batch AND b.batch_status = '0'",
                            self::DB_NAME,
                            mysqli_real_escape_string($this->db_handle, $id_batch)
        );


        $query = sprintf("UPDATE %s SET batch_status = '1' WHERE id_batch = '%s' LIMIT 1",
                            self::DB_NAME,
                            mysqli_real_escape_string($this->db_handle, $id_batch)
        );

        echo $query, PHP_EOL;    // debug

        try {
            mysqli_query($this->db_handle, $query);
        } catch (Error $e) {
            echo $query . " : " . $e, PHP_EOL;
        }
        return $this;
    }


    /**
     * Print ALL opened Batches
     * @return [type] [description]
     */
    public function printOpenBatch()
    {
        $query = sprintf("SELECT * FROM %s WHERE batch_status = '0'",
                            self::DB_NAME
        );
        try {
            echo $query, PHP_EOL;

            if ($result = mysqli_query($this->db_handle, $query) ) {
                while ($batch = mysqli_fetch_row($result)) {
                    printf("ID: %s (%s)" . PHP_EOL, $batch[0], $batch[1]);
                }

                // Free result set
                mysqli_free_result($result);
            }
        } catch (Error $e) {
            echo $query . " : " . $e, PHP_EOL;
        }
        return $this;
    }
}
?>