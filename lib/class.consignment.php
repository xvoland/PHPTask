<?php

/**
CREATE TABLE `consignment` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `id_batch` int(10) UNSIGNED NOT NULL,
  `sku` varchar(16) NOT NULL,
  `mailservice` varchar(32) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


*/

class Consignment {
    const DB_NAME = "consignment";

    private $db_handle  = null,            // handle of MySQL
            $db_last_id = null;            // last ID of added to DB

    public function __construct($mysql_handle)
    {
        if (isset($mysql_handle)) {
            $this->db_handle = $mysql_handle;
        } else {
            throw new Exception('MySQL handle is empty. Couldn\'t connect to DB ' . self::DB_NAME);
        }

        try {
            mysqli_select_db($this->db_handle, self::DB_NAME);
        } catch (Error $e) {
            throw new Exception('MySQL couldn\'t select DB ' . self::DB_NAME);
        }
    }


    public function getDbName() {
        return self::DB_NAME;
    }

    public function addConsignment() {
        // additional processing of fields can be done here
        $arrFields["id_batch"]    = $_POST["id_batch"];
        $arrFields["sku"]         = $_POST["sku"];
        $arrFields["mailservice"] = $_POST["mailservice"];
        $arrFields["firstname"]   = $_POST["firstname"];
        $arrFields["lastname"]    = $_POST["lastname"];
        $arrFields["email"]       = $_POST["email"];
        $arrFields["phone"]       = $_POST["phone"];
        $arrFields["address"]     = $_POST["address"];

        $this->add($arrFields);

        return $this;
    }

    private function add(array $fields)
    {
        if (is_array($fields)) {
            $query = sprintf(
                "INSERT INTO %s (status, id_batch, sku, mailservice, firstname, lastname, email, phone, address) "
                       ."VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                self::DB_NAME,
                0,
                mysqli_real_escape_string($this->db_handle, $fields["id_batch"]),
                mysqli_real_escape_string($this->db_handle, $fields["sku"]),
                mysqli_real_escape_string($this->db_handle, $fields["mailservice"]),
                mysqli_real_escape_string($this->db_handle, $fields["firstname"]),
                mysqli_real_escape_string($this->db_handle, $fields["lastname"]),
                mysqli_real_escape_string($this->db_handle, $fields["email"]),
                mysqli_real_escape_string($this->db_handle, $fields["phone"]),
                mysqli_real_escape_string($this->db_handle, $fields["address"])
            );
            try {
                echo "MySQL: " . $query, PHP_EOL;
                mysqli_query($this->db_handle, $query);
                $this->setLastId(mysqli_insert_id($this->db_handle));
            } catch (Error $e) {
                echo $query . " : " . $e, PHP_EOL;
            }

        }
        return $this;
    }

    public function setLastId(int $id)
    {
        $this->db_last_id = $id;
        return $this;
    }

    public function getLastId()
    {
        return $this->db_last_id;
    }


}
