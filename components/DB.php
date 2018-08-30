<?php

class DB {
    public static function getConnection() {
        $db_params = require_once(ROOT.'/config/db-params.php');
        $dbhost = $db_params['host'];
        $dbuser = $db_params['user'];
        $dbpassword = $db_params['user'];
        $dbname = $db_params['db_name'];
        $db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname);

        return $db;
    }
}