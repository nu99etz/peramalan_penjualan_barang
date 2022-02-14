<?php

if (Route::is_ajax()) {

    $sql = "select a.* , b.nama_produk from penjualan a join produk b on a.id_produk = b.id where 1 = 1 order by a.tanggal_penjualan asc";

    $query = mysqli_query($conn->connect(), $sql);

    // Maintence::debug($query);

    $record = [];
    $no = 1;

    while ($penjualan = mysqli_fetch_array($query)) {
        $row = [];
        $row[] = $no;
        $row[] = $penjualan['nama_produk'];
        $row[] = $penjualan['tanggal_penjualan'];
        $row[] = $penjualan['jumlah'];
        if (Auth::getSession('role') == 1) {
            $button = '<button type="button" name="hapus" id="' . $penjualan['id'] . '" class="hapus btn-flat btn-danger btn-sm"><i class = "fa fa-trash"></i></button> ';
            $button .= '<button type="button" name="ubah" id="' . $penjualan['id'] . '" class="ubah btn-flat btn-warning btn-sm"><i class = "fa fa-pencil"></i></button> ';
            $row[] = $button;
        }
        $record[] = $row;
        $no++;
    }

    echo json_encode([
        'data' => $record,
    ]);
}
