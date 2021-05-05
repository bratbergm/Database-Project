<?php
require_once "dbCredentials.php";
/**
 * Class Productionplan for accessing productionplan data in the database
 */
class ProductionPlanModel {
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    /**
     * Retreives a four week productionplan summary from a given period
     * @param string period The period the user wants to see the production plan for.
     * @return array The resulting array with skis and quantiy for the period
     * 
     */
    public function getRecource($period): array {
        $res = array();

        $query = "SELECT period, plan_period, ski_pnr, quantity
        FROM productionPlan
        INNER JOIN productionPlanSkis ON plan_period = period
        WHERE period = :period";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':period', $period);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();

            $res[$pos]['period'] = $row['period'];
            $res[$pos]['plan_period'] = $row['plan_period'];
            $res[$pos]['ski_pnr'] = $row['ski_pnr'];
            $res[$pos]['quantity'] = $row['quantity'];
        }
        return $res;
    }




}