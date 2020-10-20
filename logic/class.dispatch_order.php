<?php
require_once("./lib/class.dispatch_order.php");

/**
* Save Order Delivery Service Client
*/


class DispathOrder
{
    protected $mysql_handle = null,                                    // database handle
              $arrayCouriers = array('royalmail', 'anc', 'hermes'),    // couriers ID names (classes)
              $throwErrors   = false,
              $objCourier    = null;    // object of Courier

    public function __construct($mysql, $courier = 'royalmail')
    {
        // search for couriers available for sending
        // array $arrayCouriers can be filled by scanning subclass directory
        // which look like class.courier.(courier_name).php
        //
        // Example: class.courier.royalmail.php

        if (! in_array($courier, $this->arrayCouriers)) {
            throw new Exception('Courier ID - not found');
        } else {
            $objCourier = $this->setCourier($courier);
        }
    }


    /**
     * Setter/Getter for DB handle
     *
     * @param string     $mysql_handle
     *
     * @return object $this
     */
    public function setDbHandle($mysql_handle) {}
    public function getDbHandle() {}


    /**
     * Loading class functions for each courier with different behavior to save data
     *
     * @param string $name - ID name of courier from $arrayCouriers
     * @return object $this
     */
    public function setCourier($name)
    {
        // search for couriers available for sending
        // array $arrayCouriers can be filled by scanning subclass directory
        // which look like class.courier.(courier_name).php
        //
        // Example: class.courier.royalmail.php
        //
        // each class has internal functions that may differ from courier to courier
        // but the main functions of interaction with the external environment like HTTP/FTP/EMAIL etc.
        // hardcoded in the abstract class

        if (in_array($name, $this->arrayCouriers)) {
            $className   = get_class($this);
            $pathToClass = 'class.' . strtolower($className) . '/' . 'class.courier.' . $name . '.php';

            $this->objCourier = require_once($pathToClass);

            if (!($this->objCourier instanceof CourierAdapter)) {
                throw new Exception('Trying to use unknown adapter type of class.courier');
                return false;
            }
        } else {
            throw new Exception('Courier Service ' . $name . ' - is not installed');
            return false;
        }
        return $this;
    }


    /**
     * add order for courier and for us to DB for each courier individual behavior
     *
     * @param string $name - name of curier
     * @return string|false - returns uniq consignment number
     * False on error
     */
    public function addOrder($array_data)
    {
        // adding an order via an internal function in each courier class
        // that uses internal processing.
        //
        // after processing, typed functions are called, which are specified
        // in the upper layer of abstraction of CourierAdapter


        // add order to couriers
        $this->objCourier->saveDataForCouriers($array_data);

        return $this->objCourier->getUniqNumber();
    }
}

/**
* abstract class for each courier class with main send data functions (types of save data)
* and different types of data storage
*
* Example: class.courier.royalmail.php
*
*/
abstract class CourierAdapter
{

    /*
     *   here different specific abstract functions can be added for each courier
     */
    abstract public function getUniqNumber($text);                  // generate uniq number for each courier
    abstract public function saveDataForCouriers($array_or_json);   // save data individual behavior for each courier


    /**
     * Save data to mySQL. Universal function, each courier can have a different database
     *
     * NOTE: where, format - is set in the class for working with a courier
     *
     * @param string $mysql - handle to mysql
     * @param string $array_data - some data format for save in DB
     * @return boolean true|false - result of operation
     * False on error
     */
    protected function _saveDataToMySQL($mysql_db_name, $array_data)
    {
        // connect to DB

        // generate and sent sql-query to DB
        "INSERT INTO %s (status, id_batch, sku, mailservice, firstname, lastname, email, phone, address) "
                   ."VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')");

        // sent to database
        mysqli_query($mysql_handle, $query);
        mysqli_insert_id($mysql_handle);

        mysqli_close($mysql_handle);

        return true;
    }



    /**
     * Save data via FTP. Universal function, each courier can have a different FTP-server
     *
     * NOTE: where, format - is set in the class for working with a courier
     *
     * @param string $url - ftp url
     * @param string $file - some data format for save
     * @return boolean true|false - result of operation
     * False on error
     */
    protected function _sendFTP($url, $file)
    {
        // universal function for sending data via FTP
        // example: see function _saveDataToMySQL
        echo PHP_EOL . "* sended file to FTP: <b>" . $url ."</b>";

        return true;
    }


    /**
     * Send data via eMail. Universal function, each courier can have a different eMail
     *
     * NOTE: where, format - is set in the class for working with a courier
     *
     * @param string $email - email
     * @param string $email_cc - some data format for save
     * @param string $message - some message
     * @return boolean true|false - result of operation
     * False on error
     */
    protected function _sendEmail($email, $email_cc, $message)
    {
        // universal function for sending data via eMail
        echo PHP_EOL . "* sended eMail to <b>Email: " . $email . PHP_EOL
                                      . " Email_cc: " . $email_cc. PHP_EOL
                                      . " Message: "  . $message ."</b>";

        return true;
    }


    /**
     * Send data via REST API. Universal function, each courier can have a different URL, request, etc.
     *
     * NOTE: where, format - is set in the class for working with a courier
     *
     * @param string $url - ftp url
     * @param string $json - some data format for save
     * @return string|false - returns uniq consignment number
     * False on error
     */
    protected function _sendHTTP($url, $json)
    {
        // universal function for sending data via HTTP request
        echo PHP_EOL . "* sended data to URL: <b>" . $url . " : " . $json ."</b>";

        return true;
    }
}
?>

