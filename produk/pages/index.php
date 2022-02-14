<?php

defined('__VALID_ENTRANCE') or die('Dilarang Akses Halaman Ini :v');

Page::useLayout("app");

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Produk</h1>
</div>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-<?php echo $config["main-color"]; ?>">Produk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php if (Auth::getSession('role') == 1) {
            ?>
                <div style="float: right;">
                    <button type="button" class="btn btn-sm btn-primary btn-add"><i class="fa fa-plus"></i> Tambah</button>
                    <button type="button" class="btn btn-sm btn-success btn-upload"><i class="fa fa-upload"></i> Import</button>
                </div>

                <br />
                <br />
            <?php } ?>
            <table class="table table-bordered" id="produk" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <?php if (Auth::getSession('role') == 1) {
                        ?>
                            <th>Aksi</th>
                        <?php  } ?>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <?php if (Auth::getSession('role') == 1) {
                        ?>
                            <th>Aksi</th>
                        <?php  } ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php
$modal_title = "Form Produk";
$modal_id = "modal_produk";
$modal_size = "sm";
include(Route::getViewPath("include/modal"));
?>

<script>
    let _table = $("#produk");
    let _url = "<?php echo $config['base_url'] . $config['path']; ?>/produk/list_produk";

    let _modal = $('#modal_produk');
    DataTables(_url, _table);

    $(document).on('click', '.btn-add', function() {
        let _url = "<?php echo $config['base_url'] . $config['path']; ?>/produk/form_produk";
        getViewModal(_url, _modal);
    });

    $(document).on('click', '.btn-upload', function() {
        let _url = "<?php echo $config['base_url'] . $config['path']; ?>/produk/form_upload";
        getViewModal(_url, _modal);
    });

    $(document).on('click', '.hapus', function() {
        let _id = $(this).attr('id');
        let _url = "<?php echo $config['base_url'] . $config['path']; ?>/produk/hapus_produk/" + _id;
        Swal.fire({
            title: 'Apakah Anda Yakin Menghapus Data Ini ?',
            showCancelButton: true,
            confirmButtonText: `Hapus`,
            confirmButtonColor: '#d33',
            icon: 'question'
        }).then((result) => {
            if (result.value) {
                send((data, xhr = null) => {
                    if (data.status == 200) {
                        Swal.fire("Sukses", data.messages, 'success');
                        _table.DataTable().ajax.reload();
                    } else if (data.status == 422) {
                        Swal.fire("Gagal", data.messages, 'error');
                    }
                }, _url, "json", "get");
            }
        })
    });

    $(document).on('click', '.ubah', function() {
        let _id = $(this).attr('id');
        let _url = "<?php echo $config['base_url'] . $config['path']; ?>/produk/form_produk/edit/" + _id;
        getViewModal(_url, _modal);
    });

    $(document).on('submit', 'form#produk', function() {
        event.preventDefault();
        let _data = new FormData($(this)[0]);
        let _url = $(this).attr('action');

        send((data, xhr = null) => {
            if (data.status == 422) {
                FailedNotif(data.messages);
            } else if (data.status == 200) {
                SuccessNotif(data.messages);
                _modal.modal('hide');
                _table.DataTable().ajax.reload();
            }
        }, _url, "json", "post", _data);
    });

    $(document).on('submit', 'form#upload', function() {
        event.preventDefault();
        let _data = new FormData($(this)[0]);
        let _url = $(this).attr('action');

        send((data, xhr = null) => {
            if (data.status == 422) {
                FailedNotif(data.messages);
            } else if (data.status == 200) {
                SuccessNotif(data.messages);
                _modal.modal('hide');
                _table.DataTable().ajax.reload();
            }
        }, _url, "json", "post", _data);
    });
</script>

<?php Page::buildLayout(); ?>