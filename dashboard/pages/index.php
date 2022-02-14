<?php

defined('__VALID_ENTRANCE') or die('Dilarang Akses Halaman Ini :v');

Page::useLayout("app");

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="nama">
        <marquee class="bg-<?php echo $config["main-color"]; ?>" width="1095">
            <h1 style="color: white;">Halo <?php echo Auth::getSession('nama_user'); ?>, selamat kamu telah masuk sebagai <?php echo Auth::getRoleName($conn, Auth::getSession('role'), 'role_name'); ?></h1>
        </marquee>
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
        <script>
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Data Penjualan Produk Bulan Oktober & November 2020'
                },
                subtitle: {
                    text: 'Source: CV. Syana HQ'
                },
                xAxis: {
                    categories: [
                        /*'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',*/
                        'Oct',
                        'Nov',
                        //'Dec'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y} pcs </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Rosehip Oil',
                    data: [210, 190]

                }, {
                    name: 'Grapeseed',
                    data: [250, 415]

                }, {
                    name: 'Sunflower',
                    data: [180, 230]

                }, {
                    name: 'Scrub Blubella',
                    data: [123, 180]
                }, {
                    name: 'Calendula',
                    data: [160, 165]
                }, {
                    name: 'Argan',
                    data: [220, 310]
                }, {
                    name: 'Time to Glow',
                    data: [460, 390]
                }, {
                    name: 'Candlenut',
                    data: [169, 140]
                }, {
                    name: 'Avocado',
                    data: [310, 250]
                }]
            });
        </script>
    </div>
</div>

<?php Page::buildLayout(); ?>