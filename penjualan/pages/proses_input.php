<?php

require_once $config['vendor'] . "autoload.php";

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (Route::is_ajax()) {

    // proses import data excel csv
    if ($p_act == "import") {

        if (empty($_FILES['file_excel']['name'])) {
            $response = array(
                'status' => 422,
                'messages' => "file tidak ada"
            );
            echo json_encode($response);
        } else {
            $arr_file = explode(".", $_FILES['file_excel']['name']);
            $extension = end($arr_file);

            if ($extension == 'csv') {
                $reader = new Csv();
            } else {
                $reader = new Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);

            $data = $spreadsheet->getActiveSheet()->toArray();

            // function untuk menegecek jika ada data kembar maka pilih salah satu sehingga tidak terjadi data dobel
            function cek_kembar_penjualan($conn, $id_produk, $tgl)
            {
                $sql = "select id_produk, tanggal_penjualan from penjualan where id_produk = $id_produk and tanggal_penjualan = '$tgl'";
                $query = mysqli_query($conn->connect(), $sql);
                $cek = mysqli_num_rows($query);
                return $cek;
            }

            // function untuk mengambil attribut produk
            function getProduk($conn, $nama_produk, $attr)
            {
                $sql = "select*from produk where nama_produk = '$nama_produk'";
                $query = mysqli_query($conn->connect(), $sql);
                $produk = mysqli_fetch_array($query);
                return $produk[$attr];
            }

            $sqlTransaction = "START TRANSACTION";
            mysqli_query($conn->connect(), $sqlTransaction);

            $msgError = [];

            for ($i = 0; $i < count($data); $i++) {
                $nama_produk = $data[$i][0];
                $idProduk = getProduk($conn, $nama_produk, 'id');
                if (!empty($idProduk)) {
                    // jika id produk ditemukan lakukan eksekusi import data
                    $tanggal_penjualan = $data[$i][1];
                    $jumlah = $data[$i][2];
                    $cek = cek_kembar_penjualan($conn, $idProduk, $tanggal_penjualan);
                    if ($cek == 0) {
                        $sql_insert = "insert into penjualan (id_produk, tanggal_penjualan, jumlah) values ('$idProduk', '$tanggal_penjualan', '$jumlah')";
                        $query_insert = mysqli_query($conn->connect(), $sql_insert);
                    }
                } else {
                    // jika id produk tidak ditemukan maka munculkan peringatan error

                    $msgError[] = "nama produk $nama_produk tidak ditemukan<br/>";
                }
            }

            if (count($msgError) == 0) {
                $sqlTransaction = "COMMIT";
                mysqli_query($conn->connect(), $sqlTransaction);
                $response = array(
                    'status' => 200,
                    'messages' => "data sukses diimport"
                );
                echo json_encode($response);
            } else {
                $sqlTransaction = "ROLLBACK";
                mysqli_query($conn->connect(), $sqlTransaction);
                $response = array(
                    'status' => 422,
                    'messages' => $msgError
                );
                echo json_encode($response);
            }
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

            $nama_produk = $_POST['nama_produk'];
            $tanggal_penjualan = $_POST['tanggal_penjualan'];
            $jumlah = $_POST['jumlah'];

            $cek_minggu = Date::isWeekend($tanggal_penjualan);

            if (!$cek_minggu) {
                if (empty($_POST["_method"])) {
                    $sql_cek_penjualan = "select*from penjualan where id_produk = '$nama_produk' and tanggal_penjualan = '$tanggal_penjualan'";
                } else {
                    $id = $_POST['id'];
                    $sql_cek_penjualan = "select*from penjualan where id_produk = '$nama_produk' and tanggal_penjualan = '$tanggal_penjualan' and id != $id";
                }

                $query_cek_penjualan = mysqli_query($conn->connect(), $sql_cek_penjualan);
                $num_rows_cek_penjualan = mysqli_num_rows($query_cek_penjualan);

                if ($num_rows_cek_penjualan > 0) {
                    $msg = 'penjualan sudah ada';
                    $response = array(
                        'status' => 422,
                        'messages' => $msg
                    );
                    echo json_encode($response);
                } else {

                    if (empty($_POST["_method"])) {

                        $sql = "insert into penjualan (id_produk, tanggal_penjualan, jumlah) values ('$nama_produk', '$tanggal_penjualan', '$jumlah')";
                        $query = mysqli_query($conn->connect(), $sql);

                        if (!$query) {
                            $response = [
                                'status' => 422,
                                'messages' => 'Gagal Input Penjualan'
                            ];
                        } else {
                            $response = [
                                'status' => 200,
                                'messages' => 'Sukses Input Penjualan'
                            ];
                        }
                    } else {

                        if ($_POST['_method'] == "PUT") {

                            $id = $_POST['id'];

                            $sql = "update penjualan set id_produk = '$nama_produk', tanggal_penjualan = '$tanggal_penjualan', jumlah = '$jumlah' where id = $id and 1=1";

                            $query = mysqli_query($conn->connect(), $sql);

                            if (!$query) {
                                $response = [
                                    'status' => 422,
                                    'messages' => 'Gagal Update Penjualan'
                                ];
                            } else {
                                $response = [
                                    'status' => 200,
                                    'messages' => 'Sukses Update Penjualan'
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
            } else {
                $response = [
                    'status' => 422,
                    'messages' => 'Penjualan Tidak Bisa dilakukan pada hari minggu'
                ];
                echo json_encode($response);
            }
        }
    }
}
