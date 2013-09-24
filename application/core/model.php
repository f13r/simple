<?php

class Model {

    protected function mysqlConnect($dbname = '') {
        try {
            $db_name = "test";
            $db = new \PDO("mysql:host=127.0.01;dbname=" . $db_name, 'root', '');
            $db->query('SET character_set_connection = utf8;');
            $db->query('SET character_set_client = utf8;');
            $db->query('SET character_set_results = utf8;');
            $this->mysql_connect = $db;
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
        return $this->mysql_connect;
    }

}