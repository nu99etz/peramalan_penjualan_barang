<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="<?php echo $config['assets'];?>default.png">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ucfirst(Auth::getSession('nama_user'));?></span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" id = "logout" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

<script>
    $('#logout').click(function() {
        Swal.fire({
            title: 'Apakah Anda Yakin Keluar Dari Sistem ?',
            showCancelButton: true,
            confirmButtonText: `Logout`,
            confirmButtonColor: '#d33',
            icon: 'question'
        }).then((result) => {
            if (result.value) {
                let _url = "<?php echo $config['base_url'] . $config['path']; ?>/auth/proses_logout";
                send((data, xhr = null) => {
                    if (data.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: "Logout Sukses",
                            text: data.messages,
                            timer: 3000,
                            icon: 'success',
                            showCancelButton: false,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = "<?php echo $config['base_url'] . $config['path']; ?>";
                        });
                    } else if (data.status == "failed") {
                        toastr.error(data.messages);
                    }
                }, _url, "json");
            }
        })
    });
</script>