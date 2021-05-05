<?php

/**
 * Class AuthorisationModel 
 * 
 */
class AuthorisationModel {
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }


    /**
     * Check if endpoint and token matches what is stored in the database
     * @param string $token
     * @return bool token is in database or is not in database
     */
    public function validateToken(string $token): bool {

        $query = 'SELECT COUNT(*)  
        FROM auth_token
        WHERE token = :token';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':token', $token);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 1) {
            return true;
        } else {
            return false;
        }
    }



}