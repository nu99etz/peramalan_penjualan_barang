<?php

class Validation {

    public static function required($data) {
        if(empty($data)) {
            $msg = $data. " Tidak Boleh Kosong";
        }
    }
}