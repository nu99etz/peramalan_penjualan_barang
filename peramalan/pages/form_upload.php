<?php

if (Route::is_ajax()) {

?>

    <form id="upload" action="<?php echo $config['base_url'] . $config['path']; ?>/penjualan/proses_input/import" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>Nama File</label>
            <input type="file" id="file_excel" class="form-control" name="file_excel" placeholder="Nama File">
        </div>
        <div class="form-group">
            <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-warning" id="cusreset"><i class="fa fa-refresh"></i> Reset</button>
        </div>
    </form>

<?php
}
?>