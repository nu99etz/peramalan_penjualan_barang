<?php

/**
 * Kumpulan Fungsi Routing
 *
 * @author nugraha
 */

include('../config/Config.php');

class Route
{

    /*
    * Routing untuk menentukan path model yang dibutuhkan
    * @$name = string
    * @$add = string (opsional)
    */
    public static function getModelPath($name, $add = null)
    {
        global $config;

        return $config['models'] . ucfirst($name) . 'Models.php';
    }

    /*
    * Routing untuk menentukan path helper yang dibutuhkan
    * @$name = string
    * @$add = string (opsional)
    */
    public static function getHelpersPath($name, $add = null)
    {
        global $config;

        return $config['helpers'] . strtolower($name) . '.php';
    }

    /*
    * Routing untuk menentukan path asset yang dibutuhkan
    * @$name = string
    * @$add = string (opsional)
    */
    public static function getAssetPath($name, $add = null)
    {
        global $config;

        return $config['assets'] . $name;
    }

    /*
    * Routing untuk menentukan path upload yang dibutuhkan
    * @$dir = string
    * @$namefile = string
    */
    public static function setUploadPath($dir, $namefile = null)
    {
        global $config;

        if (!is_dir($config['upload'])) {
            mkdir($config['upload'], 0777);
            chmod($config['upload'], 0777);
        }

        if (!is_dir($dir)) {
            mkdir($config['upload'] . $dir, 0777);
            chmod($config['upload'] . $dir, 0777);
        }

        if (!empty($namefile)) {
            $file = $namefile;
        } else {
            $file = null;
        }

        return $config['upload'] . $dir . '/' . $file;
    }

    public static function getUploadPath($dir, $namefile = null)
    {
        global $config;

        return $config['view_upload'] . $dir . '/' . $namefile;
    }

    public static function upload($dir, $files, $name_file, $filename, $limit_size = 2097152)
    {
        $allowed_extension = array('png', 'jpg');
        $extension = strtolower(end(explode(".", $files[$name_file]['name'])));
        $size = $files[$name_file]['size'];
        $file_tmp = $files[$name_file]['tmp_name'];

        if (in_array($extension, $allowed_extension) === true) {
            if ($size < $limit_size) {
                $upload = move_uploaded_file($file_tmp, static::setUploadPath($dir, $filename . "." . $extension));
                if ($upload) {
                    return [
                        'status' => true,
                        'messages' => 'Data Sukses Terupload',
                        'files' => $filename . "." . $extension
                    ];
                } else {
                    return [
                        'status' => false,
                        'messages' => 'Data Gagal Terupload'
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'messages' => 'Data Gagal Terupload Karena Size Terlalu Besar'
                ];
            }
        } else {
            return [
                'status' => false,
                'messages' => 'Data Gagal Terupload Karena Ekstensi Tidak Diijinkan'
            ];
        }
    }

    /*
    * Routing untuk menentukan view path yang dibutuhkan
    * @$dir = string
    * @$namefile = string
    */
    public static function getViewPath($view)
    {
        global $config;

        if (is_file('pages/' . $view . '.php')) {
            return 'pages/' . $view . '.php';
        } else if (!is_file($view)) {
            return '../common/views/' . $view . '.php';
        }
    }

    /*
    * Routing untuk mendapatkan alamat URL Statis
    * @return $destination, $destination_link
    */
    public static function navAddress()
    {
        $linkaddress = explode('/', $_SERVER['REQUEST_URI']);
        $destination_link = explode('_', $linkaddress[3]);
        $destination = 'data_' . $destination_link[1];
        if (count($linkaddress) == 4) {
            return $destination . '/';
        } else if (count($linkaddress) == 5) {
            return '../' . $destination . '/';
        } else if ($linkaddress == 3) {
            return $destination_link;
        }
    }

    public static function getThisPage($view = null)
    {
        global $page;
        if (!empty($view)) {
            $pages = $view;
        } else {
            $pages = $page;
        }

        return $pages;
    }

    public static function backToPage()
    {
        $linkaddress = explode('/', $_SERVER['REQUEST_URI']);
        $destination_link = explode('_', $linkaddress[3]);
        $destination = 'list_' . $destination_link[1];
        if (count($linkaddress) == 4) {
            return $destination . '/';
        } else if (count($linkaddress) == 5) {
            return '../' . $destination . '/';
        } else if ($linkaddress == 3) {
            return $destination_link;
        }
    }

    public static function selfPage()
    {
        $explode_link = explode('/', $_SERVER['REQUEST_URI']);
        $rim = count($explode_link);
        if ($rim == 5) {
            return '../' . $explode_link[3];
        } else if ($rim == 4) {
            return $explode_link[3];
        }
    }

    public static function selfgetPage()
    {
        $explode_link = explode('/', $_SERVER['REQUEST_URI']);
        $explode_link2 = explode('_', $explode_link[3]);
        return '../../' . 'list_' . $explode_link2[1];
    }

    /*
    * Routing untuk mendapatkan Flash Data
    * @$data = string
    * @$msg = string
    * @return $flash
    */
    public static function getFlashData($data, $msg)
    {
        if ($data == 'success') {
            $_SESSION['POS']['FLASH'] = array(
                'post_ok' => true,
                'color' => 'success',
                'msg' => $msg
            );
        } else if ($data == 'failed') {
            $_SESSION['POS']['FLASH'] = array(
                'post_err' => true,
                'color' => 'danger',
                'msg' => $msg
            );
        }
        $flash = $_SESSION['POS']['FLASH'];
        unset($_SESSION['POS']['FLASH']);
        return $flash;
    }

    /*
    * Routing untuk set Flash Data
    * @$flash = array()
    */
    public static function setFlashData($flash)
    {

        $_SESSION['POS']['FLASH'] = $flash;
    }
    /*
    * Routing untuk mendirect halaman
    * @param $url = string (optional)
    * @$status = string (optional)
    * @$messages = string(optional)
    */
    public static function redirect($url = null)
    {

        header("location:" . $url);
        exit();
    }

    public static function Add()
    {
        return "add-action.php";
    }

    public static function is_ajax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
}
