<?php

if (Route::is_ajax()) {

    $sql = "select*from produk where 1 = 1";

    $query = mysqli_query($conn->connect(), $sql);

    $record = [];
    $no = 1;

    while ($produk = mysqli_fetch_array($query)) {
        $row = [];
        $row[] = $no;
        $row[] = $produk['nama_produk'];
        if(Auth::getSession('role') == 1) {
            $button = '<button type="button" name="hapus" id="' . $produk['id'] . '" class="hapus btn-flat btn-danger btn-sm"><i class = "fa fa-trash"></i></button> ';
            $button .= '<button type="button" name="ubah" id="' . $produk['id'] . '" class="ubah btn-flat btn-warning btn-sm"><i class = "fa fa-pencil"></i></button> ';
            $row[] = $button;
        }
        $record[] = $row;
        $no++;
    }

    echo json_encode([
        'data' => $record,
    ]);
}
