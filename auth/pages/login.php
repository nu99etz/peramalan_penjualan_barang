<!DOCTYPE html>
<html>

<head>
    <?php include(Route::getViewPath('include/header')); ?>
</head>

<body class="bg-gradient-<?php echo $config["main-color"]; ?>">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistem Peramalan Penjualan Barang </h1>
                                        <h1 class="h4 text-gray-900 mb-4">Di CV. Syana</h1>
                                    </div>
                                    <form id="form-login" action="<?php echo $config['base_url'] . $config['path']; ?>/auth/proses_login/login" class="user">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mt-2">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group mt-2">
                                            <button type="submit" class="btn btn-<?php echo $config["main-color"]; ?> btn-user btn-block">
                                                <i class="fa fa-sign-in"></i> Masuk
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- /.login-box -->
        <script>
            $('#form-login').on('submit', function() {
                event.preventDefault();
                let _data = new FormData($(this)[0]);
                let _url = $('#form-login').attr('action');
                console.log(_url)
                send((data, xhr = null) => {
                    if(data.status == 200) {
                        Swal.fire({
                            type: 'success',
                            title: "Login Sukses",
                            text: data.messages,
                            timer: 3000,
                            icon: 'success',
                            showCancelButton: false,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = "<?php echo $config['base_url'] . $config['path']; ?>";
                        });
                    } else if(data.status == 402) {
                        FailedNotif(data.messages);
                    }
                }, _url, "json", "post", _data);
            });
        </script>


</body>

</html>