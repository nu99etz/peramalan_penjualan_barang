<?php

if (Route::is_ajax()) {

    $sql_produk = "select*from produk where 1=1";
    $query_produk = mysqli_query($conn->connect(), $sql_produk);

?>
    <form id="peramalan" action="<?php echo $config['base_url'] . $config['path']; ?>/peramalan/proses_hitung" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>Nama Produk</label>
            <select id="nama_produk" class="form-control" name="nama_produk">
                <?php while ($produk = mysqli_fetch_array($query_produk)) {
                ?><option value="<?php echo $produk['id']; ?>"><?php echo $produk['nama_produk']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Alpha</label>
            <select id="alpha" class="form-control" name="alpha">
                <?php for ($i = 1; $i <= 9; $i++) {
                ?><option value="<?php echo "0.".$i;?>"><?php echo "0.".$i; ?></option>
                <?php   } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Penjualan 1</label>
            <input type="date" id="tanggal_1" class="form-control" name="tanggal_1" placeholder="Tanggal Penjualan 1">
        </div>

        <div class="form-group">
            <label>Tanggal Penjualan 2</label>
            <input type="date" id="tanggal_2" class="form-control" name="tanggal_2" placeholder="Tanggal Penjualan 2">
        </div>

        <div class="form-group">
            <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-warning" id="cusreset"><i class="fa fa-refresh"></i> Reset</button>
        </div>
    </form>

<?php
}
?>