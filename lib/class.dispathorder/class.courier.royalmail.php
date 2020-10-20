<?php


class CourierRoyalMail extends CourierAdapter {

    protected const DB_NAME = "consignment";    // DB name for save Royal Mail orders


    /**
     * Save Data To mySQL or other methods in abstract class CourierAdapter
     *
     * @param string $array_or_json - some data for save
     * @return string|false - Returns uniq number
     * False on error
     */
    public function saveDataForCouriers($array_or_json) {

        // prepare data, URL for sending
        parent::_saveDataToMySQL(self::DB_NAME, $array_or_json);

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
        $uniqNumber = empty($key) ? crc32(time()) : $key;

        echo PHP_EOL . "* generate class <i>" . get_class($this) . "</i> some uniq number: " . $uniqNumber;

        return $uniqNumber;
    }
}

return new CourierRoyalMail();
