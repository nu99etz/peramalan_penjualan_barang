<?php

defined('__VALID_ENTRANCE') or die('Dilarang Akses Halaman Ini :v');

Page::useLayout("app");

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Peramalan Penjualan</h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-<?php echo $config["main-color"]; ?>">Peramalan Penjualan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <button type="button" class="btn btn-sm btn-primary float-right btn-add"><i class="fa fa-refresh"></i> Hitung</button>
            <br />
            <br />
            <p>
            <h3 class="alpha-guna"></h3>
            </p>
            <table class="table table-bordered" id="peramalan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Tanggal Penjualan</th>
                        <th>Bulan Penjualan</th>
                        <th>Tahun Penjualan</th>
                        <th>Data Aktual</th>
                        <th>Forecast</th>
                        <th>MAPE</th>
                    </tr>
                </thead>
                <tbody id="hasil-ramalan"></tbody>
            </table>
            <br />
            <p>
            <h3 class="mape-avg"></h3>
            </p>

            <div class="chart-area">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
</div>

<?php
$modal_title = "Form Peramalan";
$modal_id = "modal_peramalan";
$modal_size = "sm";
include(Route::getViewPath("include/modal"));
?>

<script>
    let _url = "<?php echo $config['base_url'] . $config['path']; ?>/penjualan/list_penjualan";

    let _modal = $('#modal_peramalan');

    let _table = $('#peramalan');

    let _chart = $('#chart');

    var linechart = new Chart(_chart, {
        type: 'line',
    });

    $(document).on('click', '.btn-add', function() {
        let _url = "<?php echo $config['base_url'] . $config['path']; ?>/peramalan/form_peramalan";
        getViewModal(_url, _modal);
    });

    $(document).on('submit', 'form#peramalan', function() {
        event.preventDefault();
        let _data = new FormData($(this)[0]);
        let _url = $(this).attr('action');

        send((data, xhr = null) => {
            if (data.status == 200) {
                _modal.modal('hide');
                $('.alpha-guna').html("Alpha Yang Digunakan Sebesar = " + data.alpha);
                $('#hasil-ramalan').html(data.html);
                $('.mape-avg').html("Rata-rata mape sebesar = " + data.avg_mape);
                linechart.destroy();
                linechart = new Chart(_chart, {
                    type: 'line',
                    data: {
                        labels: data.chart['tanggal'],
                        datasets: [{
                                label: 'Aktual',
                                data: data.chart['aktual'],
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            },
                            {
                                label: 'Ramal',
                                data: data.chart['ramal'],
                                borderColor: 'rgba(192, 192, 192, 1)',
                                backgroundColor: 'rgba(192, 192, 192, 0.2)',
                            }
                        ],
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value, index, values) {
                                            return value;
                                        }
                                    }
                                }]
                            },
                        }
                    }
                });
            } else if (data.status == 422) {
                FailedNotif(data.messages);
            }
        }, _url, "json", "post", _data);
    });
</script>

<?php Page::buildLayout(); ?>