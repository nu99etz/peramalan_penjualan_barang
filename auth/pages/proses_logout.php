<?php

if (Route::is_ajax()) {

    session_destroy();
    ob_clean();

    echo json_encode([
        'status' => "success",
        'messages' => 'Logout Sukses'
    ]);

    session_start();
}
