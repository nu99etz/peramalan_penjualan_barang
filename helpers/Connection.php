<?php


class Connection {

    private $db_name;
    private $servername;
    private $username;
    private $password;

    public function __construct($db_name, $servername, $username, $password) {
      $this->db_name = $db_name;
      $this->servername = $servername;
      $this->username = $username;
      $this->password = $password;
    }

    public function getConnection($db_driver = "mysqli") {
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db_name);
      if($conn->connect_error) {
        return "Connection Error ". $conn->connect_error;
      }
      return $conn;
    }
}