<?php

if (Route::is_ajax()) {

    if ($p_act == "edit" && !empty($id)) {

        // Ambil Data Produk sesuai data yang mau diedit
        $sql = "select*from produk where id = $id and 1=1";
        $query = mysqli_query($conn->connect(), $sql);
        $produk = mysqli_fetch_assoc($query);

        $nama_produk = $produk['nama_produk'];
    } else {
        $nama_produk = "";
    }

?>

    <form id="produk" action="<?php echo $config['base_url'] . $config['path']; ?>/produk/proses_input" method="post" enctype="multipart/form-data">

        <?php if ($p_act == "edit" && !empty($id)) {
        ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php } ?>

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" id="nama_produk" class="form-control" name="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_produk; ?>">
        </div>
        <div class="form-group">
            <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-warning" id="cusreset"><i class="fa fa-refresh"></i> Reset</button>
        </div>
    </form>

<?php
}
?>