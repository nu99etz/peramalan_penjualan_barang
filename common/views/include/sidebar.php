<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-<?php echo $config["main-color"]; ?> sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $config['base_url'] . $config['path']; ?>">
        <div class="sidebar-brand-text mx-3"><?php echo $config['tenants-name']; ?></div>
    </a>


    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['base_url'] . $config['path']; ?>/dashboard/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['base_url'] . $config['path']; ?>/produk/">
            <i class="fas fa-fw fa-database"></i>
            <span>Data Produk</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['base_url'] . $config['path']; ?>/penjualan/">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Data Penjualan</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['base_url'] . $config['path']; ?>/peramalan/">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Data Peramalan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
<!-- End of Sidebar -->

<script>
    $(document).ready(function() {
        let menu = $('#accordionSidebar').find('a');
        for (var i = 0; i < menu.length; i++) {
            href = menu.eq(i).attr('href');
            if (window.location.href == href) {
                menu.eq(i).parents('li').addClass('active');
                menu.eq(i).addClass('active');
                menu.eq(i).parents('div').parents('div').addClass('show');
            }
        }
    })
</script>