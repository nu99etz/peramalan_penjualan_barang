<?php

if (Route::is_ajax()) {

    if ($p_act == "login") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $msg_error = '';
        $msg_success = '';

        if (!empty($username) && !empty($password)) {

            $password = md5($password);

            $sql = "select*from user where username = '$username' and password = '$password' and 1 = 1";

            $query = mysqli_query($conn->connect(), $sql);

            if (!$query) {
                $msg_error = "username dan password tidak ditemukan";
                
            } else {
                $login = mysqli_fetch_assoc($query);

                if ($login == NULL) {
                    $msg_error = "username dan password tidak ditemukan";
                } else {

                    if ($login['username'] != $username) {
                        $msg_error = "username tidak ditemukan";
                    } else if ($login['password'] != $password) {
                        $msg_error = "password tidak ditemukan";
                    } else {
                        $msg_success = "Login Sukses Anda Akan Diarahkan Dalam 5 Detik ...";
                        $session = [
                            'id' => $login['id'],
                            'nama_user' => $login['nama_user'],
                            'role' => $login['role'],
                        ];
                        Auth::setSession($session);
                    }
                }
            }

            if (empty($msg_error)) {
                $response = [
                    'status' => 200,
                    'messages' =>  $msg_success
                ];
            } else if (empty($msg_success)) {
                $response = [
                    'status' => 402,
                    'messages' => $msg_error
                ];
            }

            echo json_encode($response);
        } else {
            if (empty($username) && empty($password)) {
                $msg = "Username dan password harus diisi";
            } else if (empty($username)) {
                $msg = 'Username harus diisi';
            } else if (empty($password)) {
                $msg = 'Password harus diisi';
            }
            $response = [
                'status' => 402,
                'messages' => $msg
            ];
            echo json_encode($response);
        }
    }
}
