<?php

/**
 * Class Skis for accessing ski data in the dbproject database
 * 
 */
class SkiModel {
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    /**
     * Creates a record of skis produced after a given date. (Create records newly produced skis)   Inner join med skitypes 1!
     * Needs '' around date in the URI Example: http://127.0.0.1/dbproject/skis/date/'2021-03-02'
     * Storekeeper endpoint
     */
    public function getRecord(string $date) {
        $res = array();
       
        $query = "SELECT `pnr`, `size`, `weightClass`,`productionDate`
        FROM ski
        WHERE productionDate >= $date";
       
       $stmt = $this->db->query($query);

       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();

            $res[$pos]['pnr'] = $row['pnr'];
            $res[$pos]['size'] = $row['size'];
            $res[$pos]['weightClass'] = $row['weightClass'];
            $res[$pos]['productionDate'] = $row['productionDate'];
       }
    
        return $res;
       
       
       
       /*
       $query = "SELECT `pnr`,`type`,`model`, `temperature`, `size`, `weightClass`, `gripSystem`,`productionDate`
        FROM ski
        WHERE productionDate = :productionDate";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':productionDate', $date);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = $row;

        /*

            /*
            $pos = count($res);
            $res[] = array();


            $res[$pos]['pnr'] = $row['pnr'];
            $res[$pos]['size'] = $row['size'];
            $res[$pos]['weightClass'] = $row['weightClass'];
            $res[$pos]['productionDate'] = $row['productionDate'];
            $res[$pos]['type'] = $row['type'];
            $res[$pos]['model'] = $row['model'];
            $res[$pos]['temperature'] = $row['temperature'];
            $res[$pos]['gripSystem'] = $row['gripSystem'];
*/           

    }

    /**
     * Retreives all skis. (Add skitypes?)
     * @return array Returns an array of associative arrays with the requested data.
     *               If the data is not found, it returns an empty array.
     */
    public function getCollection() {
        $res = array();
        $stmt = $this->db->prepare("SELECT `pnr`, `size`, `weightClass`, `productionDate`
        FROM ski");

        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * Retreives one ski based on product number (pnr)
     * @param int $pnr The skis production number
     * @return array Returns an array of associative arrays with the requested data.
     *               If the data is not found, it returns an empty array.
     */
    public function getRecource($pnr) {
        $res = array();
        $stmt = $this->db->prepare("SELECT `pnr`, `size`, `weightClass`,`productionDate`, `ski`.`ski_type_id`, `skitype`.`id`, `skitype`.`type`, `skitype`.`model`, `skitype`.`temperature`, `skitype`.`gripSystem`, `skitype`.`typeOfSkiing`, `skitype`.`descripton`, `skitype`.`historical`, `skitype`.`msrp`
        FROM ski
        INNER JOIN skitype ON skitype.id = ski.ski_type_id
        WHERE `pnr` = :pnr");

        $stmt->bindValue('pnr', $pnr);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }








}