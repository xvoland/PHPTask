<?php


class CourierANC extends CourierAdapter {

    protected static $_FTP = "ftp://anc";


    /**
     * Save Data To mySQL or other methods in abstract class CourierAdapter
     *
     * @param string $array_or_json - some data for save
     * @return string|false - Returns uniq number
     * False on error
     */
    public function saveDataForCouriers($array_or_json) {

        // prepare data, URL for sending
        parent::_sendFTP(self::$_FTP, $array_or_json);

        return true;
    }


    /**
     * Get Unique Number (Each consignment will be given a unique number)
     *
     * @param string $key - some data for generation
     * @return string|false - Returns uniq number
     * False on error
     */

    public function getUniqNumber($key = null) {
        // generate uniq number
        $uniqNumber = base64_encode(time());

        echo PHP_EOL . "* generate class <i>" . get_class($this) . "</i> some uniq number: " . $uniqNumber;

        return $uniqNumber;
    }
}

return new CourierANC();
