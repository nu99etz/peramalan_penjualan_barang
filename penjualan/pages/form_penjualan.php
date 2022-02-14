<?php

if (Route::is_ajax()) {

    $sql_produk = "select*from produk where 1=1";
    $query_produk = mysqli_query($conn->connect(), $sql_produk);

    if ($p_act == "edit" && !empty($id)) {

        // Ambil Data Produk sesuai data yang mau diedit
        $sql = "select*from penjualan where id = $id and 1=1";
        $query = mysqli_query($conn->connect(), $sql);
        $penjualan = mysqli_fetch_assoc($query);

        $nama_produk = $penjualan['id_produk'];
        $tanggal_penjualan = $penjualan['tanggal_penjualan'];
        $jumlah = $penjualan['jumlah'];
    } else {
        $nama_produk = "";
        $tanggal_penjualan = "";
        $jumlah = "";
    }

?>

    <form id="produk" action="<?php echo $config['base_url'] . $config['path']; ?>/penjualan/proses_input" method="post" enctype="multipart/form-data">

        <?php if ($p_act == "edit" && !empty($id)) {
        ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php } ?>

        <div class="form-group">
            <label>Nama Produk</label>
            <select id="nama_produk" class="form-control" name="nama_produk">
                <?php while ($produk = mysqli_fetch_array($query_produk)) {
                    if ($produk['id'] == $nama_produk) {
                ?>
                        <option value="<?php echo $produk['id']; ?>" selected><?php echo $produk['nama_produk']; ?></option>
                    <?php    } else {
                    ?><option value="<?php echo $produk['id']; ?>"><?php echo $produk['nama_produk']; ?></option>
                    <?php } ?>
                <?php   } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Penjualan</label>
            <input type="date" id="tanggal_penjualan" class="form-control" name="tanggal_penjualan" placeholder="Tanggal Penjualan" value="<?php echo $tanggal_penjualan; ?>">
        </div>

        <div class="form-group">
            <label>Jumlah Penjualan</label>
            <input type="number" id="jumlah" class="form-control" name="jumlah" placeholder="Jumlah Penjualan" value="<?php echo $jumlah; ?>">
        </div>

        <div class="form-group">
            <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-warning" id="cusreset"><i class="fa fa-refresh"></i> Reset</button>
        </div>
    </form>

<?php
}
?>