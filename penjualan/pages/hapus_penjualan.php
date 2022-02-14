<?php

if (Route::is_ajax()) {

    if ($p_act == 'all') {

        $sql = "delete from penjualan";

        $query = mysqli_query($conn->connect(), $sql);

        if (!$query) {
            $response = [
                'status' => 422,
                'messages' => 'Hapus Semua Penjualan Gagal'
            ];
        } else {
            $response = [
                'status' => 200,
                'messages' => 'Hapus Semua Penjualan Sukses'
            ];
        }

        echo json_encode($response);
    } else {

        $id = $p_act;

        $sql = "delete from penjualan where id = $id";

        $query = mysqli_query($conn->connect(), $sql);

        if (!$query) {
            $response = [
                'status' => 422,
                'messages' => 'Hapus Penjualan Gagal'
            ];
        } else {
            $response = [
                'status' => 200,
                'messages' => 'Hapus Penjualan Sukses'
            ];
        }

        echo json_encode($response);
    }
}
