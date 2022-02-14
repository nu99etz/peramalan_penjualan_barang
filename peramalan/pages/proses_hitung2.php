<?php

if (Route::is_ajax()) {

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
        $tgl_1 = $_POST['tanggal_1'];
        $tgl_2 = $_POST['tanggal_2'];
        $alpha = $_POST['alpha'];

        $sql_penjualan = "select a.*, b.nama_produk from penjualan a join produk b on a.id_produk = b.id where a.tanggal_penjualan between '$tgl_1' and '$tgl_2' and a.id_produk = $nama_produk";
        $query_penjualan = mysqli_query($conn->connect(), $sql_penjualan);

        $i = 1;
        $html = "";
        $expo1_sebelumnya = 0;
        $expo2_sebelumnya = 0;
        $ramal_selanjutnya = 0;
        $sum_mape = 0;

        $chart = [];

        while ($penjualan = mysqli_fetch_assoc($query_penjualan)) {
            if ($i == 1) {
                $data_aktual = $penjualan['jumlah'];
                $expo1 = $data_aktual;
                $expo2 = $expo1;
                $pemulu1 = $expo2;
                $pemulu2 = ($alpha / (1 - $alpha)) * ($expo1 - $expo2);
                $forecast = $pemulu1 + $pemulu2;
                $mape = (100 / 1) * abs(($data_aktual - $forecast) / $data_aktual);
                $expo1_sebelumnya = $expo1;
                $expo2_sebelumnya = $expo2;
                $ramal_selanjutnya = $forecast;
            } else {
                $data_aktual = $penjualan['jumlah'];
                $expo1 = $alpha * $data_aktual + (1 - $alpha) * $expo1_sebelumnya;
                $expo2 = $alpha * $expo1 + (1 - $alpha) * $expo2_sebelumnya;
                $pemulu1 = 2 * ($expo1) - $expo2;
                $pemulu2 = ($alpha / (1 - $alpha)) * ($expo1 - $expo2);
                $forecast = $ramal_selanjutnya;
                $mape = (100 / 1) * abs(($data_aktual - $forecast) / $data_aktual);
                $expo1_sebelumnya = $expo1;
                $expo2_sebelumnya = $expo2;
                $ramal_selanjutnya = $pemulu1 + $pemulu2;
            }

            $nama_produk = $penjualan['nama_produk'];
            $last_date = $penjualan['tanggal_penjualan'];
            $last_forecast = $forecast;

            $sum_mape += $mape;

            $html .= '<tr>';
            $html .= '<td>' . $i . '</td>';
            $html .= '<td>' . $penjualan['nama_produk'] . '</td>';
            $html .= '<td>' . date('d', strtotime($penjualan['tanggal_penjualan'])) . '</td>';
            $html .= '<td>' . date('m', strtotime($penjualan['tanggal_penjualan'])) . '</td>';
            $html .= '<td>' . date('Y', strtotime($penjualan['tanggal_penjualan'])) . '</td>';
            $html .= '<td>' . $data_aktual . '</td>';
            // $html .= '<td>' . number_format($expo1, 2) . '</td>';
            // $html .= '<td>' . number_format($expo2, 2) . '</td>';
            // $html .= '<td>' . number_format($pemulu1, 2) . '</td>';
            // $html .= '<td>' . number_format($pemulu2, 2) . '</td>';
            $html .= '<td>' . number_format($forecast, 2) . '</td>';
            $html .= '<td>' . number_format($mape, 2) . '</td>';
            $html .= '</tr>';

            $chart['aktual'][] = $data_aktual;
            $chart['ramal'][] = $forecast;
            $chart['tanggal'][] = $penjualan['tanggal_penjualan'];

            $i++;
        }

        $avg_mape = $sum_mape / ($i - 1);

        $last_no = $i;

        $diff = Date::datediff($last_date, $tgl_2);

        if ($diff > 0) {
            // Maintence::debug($diff);
            for ($i = 0; $i < $diff; $i++) {
                $forecast = $pemulu1 + ($pemulu2 * ($i + 1));
                $next_date = date('Y-m-d', strtotime('+1 day', strtotime($last_date)));
                $html .= '<tr>';
                $html .= '<td>' . $last_no . '</td>';
                $html .= '<td>' . $nama_produk . '</td>';
                $html .= '<td>' . date('d', strtotime($next_date)) . '</td>';
                $html .= '<td>' . date('m', strtotime($next_date)) . '</td>';
                $html .= '<td>' . date('Y', strtotime($next_date)) . '</td>';
                $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                $html .= '<td>' . number_format($forecast, 2) . '</td>';
                $html .= '<td> - </td>';
                $html .= '</tr>';

                // $chart_berikut['ramal'][] = $forecast;
                // $chart_berikut['tanggal'][] = $next_date;
                array_push($chart['ramal'], $forecast);
                array_push($chart['tanggal'], $next_date);

                $last_date = $next_date;
                $last_no++;
            }
        } else {
            for ($i = 0; $i < 6; $i++) {
                $forecast = $pemulu1 + ($pemulu2 * ($i + 1));
                $next_date = date('Y-m-d', strtotime('+1 day', strtotime($last_date)));
                $html .= '<tr>';
                $html .= '<td>' . $last_no . '</td>';
                $html .= '<td>' . $nama_produk . '</td>';
                $html .= '<td>' . date('d', strtotime($next_date)) . '</td>';
                $html .= '<td>' . date('m', strtotime($next_date)) . '</td>';
                $html .= '<td>' . date('Y', strtotime($next_date)) . '</td>';
                $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                // $html .= '<td> - </td>';
                $html .= '<td>' . number_format($forecast, 2) . '</td>';
                $html .= '<td> - </td>';
                $html .= '</tr>';

                // $chart_berikut['ramal'][] = $forecast;
                // $chart_berikut['tanggal'][] = $next_date;
                array_push($chart['ramal'], $forecast);
                array_push($chart['tanggal'], $next_date);

                $last_date = $next_date;
                $last_no++;
            }
        }

        // array_push($chart['ramal'], $chart_berikut['ramal']);

        // Maintence::debug($chart);

        echo json_encode([
            'status' => 200,
            'alpha' => $alpha,
            'html' => $html,
            'avg_mape' => number_format($avg_mape, 2),
            'chart' => $chart
        ]);
    }
}
