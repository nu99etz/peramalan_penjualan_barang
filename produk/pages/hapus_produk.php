<?php

if (Route::is_ajax()) {

    $id = $p_act;

    $sql_penjualan = "delete from penjualan where id_produk = $id";
    $sql_produk = "delete from produk where id = $id";

    $query_penjualan = mysqli_query($conn->connect(), $sql_penjualan);
    $query_produk = mysqli_query($conn->connect(), $sql_produk);

    if(!$query_produk) {
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