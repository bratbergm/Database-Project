<?php


/**
 * Class for ski types. 
 * 
 */
class SkiTypeModel {

    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }


    /**
     * Retreives all skitypes
     */
    public function getCollection(): array {
        $res = array();
        $stmt = $this->db->prepare("SELECT type, model, temperature, gripSystem, typeOfSkiing, descripton, historical, msrp
        FROM skitype");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = $row;
        }

        return $res;
    }

    /**
     * Retreives list of ski types based on model (Public endpoint)
     */
    public function getResource(string $model): array {
        $res = array();
        $stmt = $this->db->prepare("SELECT type, model, temperature, gripSystem, typeOfSkiing, descripton, historical, msrp
        FROM skitype
        WHERE model = :model"); 

        $stmt->bindValue('model', $model);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = $row;
        }
        return $res;
    }

}