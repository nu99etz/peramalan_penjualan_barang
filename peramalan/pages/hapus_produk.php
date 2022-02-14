<?php

if (Route::is_ajax()) {

    $id = $p_act;

    $sql = "delete from produk where id = $id";

    $query = mysqli_query($conn->connect(), $sql);

    if(!$sql) {
        $response = [
            'status' => 422,
            'messages' => 'Hapus Produk Gagal'
        ];
    } else {
        $response = [
            'status' => 200,
            'messages' => 'Hapus Produk Sukses'
        ];
    }

    echo json_encode($response);
}