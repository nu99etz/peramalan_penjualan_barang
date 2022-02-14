<?php

require_once $config['vendor']."autoload.php";
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (Route::is_ajax()) {

    // proses import data via excel csv
    if ($p_act == "import") {

        if(empty($_FILES['file_excel']['name'])) {
            $response = array(
                'status' => 422,
                'messages' => "file tidak ada"
            );
            echo json_encode($response);
        } else {
            $arr_file = explode(".", $_FILES['file_excel']['name']);
            $extension = end($arr_file);

            if($extension == 'csv') {
                $reader = new Csv();
            } else {
                $reader = new Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);

            $data = $spreadsheet->getActiveSheet()->toArray();

            // Maintence::debug($data);

            // function untuk menegecek jika ada data kembar maka pilih salah satu sehingga tidak terjadi data dobel
            function cek_kembar_produk($conn, $data)
            {
                $sql = "select nama_produk from produk where nama_produk = '".$data."'";
                $query = mysqli_query($conn->connect(), $sql);
                $cek = mysqli_num_rows($query);
                return $cek;
            }

            // $sql_truncate = "TRUNCATE TABLE produk";
            // $query_truncate = mysqli_query($conn->connect(), $sql_truncate);

            for($i = 0; $i < count($data); $i ++) {
                $nama_produk = $data[$i][0];
                $cek = cek_kembar_produk($conn, $nama_produk);
                if($cek == 0) {
                    $sql = "insert into produk (nama_produk) values ('$nama_produk')";
                    $query = mysqli_query($conn->connect(), $sql);
                }     
            }

            $response = array(
                'status' => 200,
                'messages' => "data sukses diimport"
            );
            echo json_encode($response);
        }

    } else {

        // validasi data
        $msg = array();
        foreach ($_POST as $key => $value) {
            if (empty($_POST[$key])) {
                $msg[$key] = $key . " Tidak Boleh Kosong";
            }
        }

        if ($msg) {
            $error_validation = implode("<br/>", $msg);
            $response = array(
                'status' => 422,
                'messages' => $error_validation
            );
            echo json_encode($response);
        } else {

            // proses insert data
            if (empty($_POST["_method"])) {

                $nama_produk = $_POST['nama_produk'];
                $sql = "insert into produk (nama_produk) values ('$nama_produk')";
                $query = mysqli_query($conn->connect(), $sql);

                if (!$query) {
                    $response = [
                        'status' => 422,
                        'messages' => 'Gagal Input Produk'
                    ];
                } else {
                    $response = [
                        'status' => 200,
                        'messages' => 'Sukses Input Produk'
                    ];
                }
            } else {

                // proses update data
                if ($_POST['_method'] == "PUT") {
                    $nama_produk = $_POST['nama_produk'];
                    $id = $_POST['id'];

                    $sql = "update produk set nama_produk = '$nama_produk' where id = $id and 1=1";

                    $query = mysqli_query($conn->connect(), $sql);

                    if (!$query) {
                        $response = [
                            'status' => 422,
                            'messages' => 'Gagal Update Produk'
                        ];
                    } else {
                        $response = [
                            'status' => 200,
                            'messages' => 'Sukses Update Produk'
                        ];
                    }
                } else {
                    $response = [
                        'status' => 422,
                        'messages' => 'Gagal Update Produk'
                    ];
                }
            }

            echo json_encode($response);
        }
    }
}
