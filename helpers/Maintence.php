<?php

class Maintence {

    public static function debug($data)
    {
        if(is_array($data) || is_object($data)) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die();
        } else {
            var_dump($data);
            die();
        }
    }

    public static function insertLog($conn, $nama_user, $ip_address, $activity_log, $activity_date, $parameters, $is_success)
    {
        $sql = "insert into activity_log (nama_user, ip_address, activity_log, activity_date, parameters, is_success) values ('$nama_user', '$ip_address', '$activity_log', '$activity_date', '$parameters', '$is_success')";
        $conn->getQuery($sql);
    }
}