<?php

class Auth
{
    public static function isLogin()
    {
        $login = self::getLoginStatus();
        if ($login) {
            return true;
        } else {
            return false;
        }
    }

    public static function setLoginStatus()
    {
        $_SESSION['apps']['login'] = true;
    }

    public static function getLoginStatus()
    {
        return $_SESSION['apps']['login'];
    }

    public static function setLoginGuest($is_guest)
    {
        $_SESSION['apps']['login_guest'] = $is_guest;
    }

    public static function getLoginGuest()
    {
        return $_SESSION['apps']['login_guest'];
    }

    public static function setID($id)
    {
        $_SESSION['apps']['user_id'] = $id;
    }

    public static function getID()
    {
        return $_SESSION['apps']['user_id'];
    }

    public static function setNameLogin($name)
    {
        $_SESSION['apps']['login_name'] = $name;
    }

    public static function getNameLogin()
    {
        return $_SESSION['apps']['login_name'];
    }

    public static function setLastLogin($last_login)
    {
        $_SESSION['apps']['last_login'] = $last_login;
    }

    public static function getLastLogin()
    {
        return $_SESSION['apps']['last_login'];
    }

    public static function getSession($attr)
    {
        return $_SESSION['apps'][$attr];
    }

    public static function setSession(array $data)
    {   
        self::setLoginStatus();
        foreach($data as $key => $value) {
            $_SESSION['apps'][$key] = $value;
        }
    }

    public static function getRoleName($conn, $id, $attr)
    {
        $sql = "select*from role where id = ". $id;
        $role = $conn->fetchRow($sql);
        return $role[$attr];
    }
}
