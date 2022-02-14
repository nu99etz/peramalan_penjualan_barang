<?php

require_once("Connection.php");

class Query
{

    private $conn;
    private $tablename;

    public function __construct($config)
    {
        $conn = new Connection($config['db_name'], $config['db_host'], $config['db_username'], $config['db_password']);
        $this->conn = $conn->getConnection();
    }

    public function connect()
    {
        return $this->conn;
    }

    public function setTableName($tablename)
    {
        $this->tablename = $tablename;
    }

    public function getTableName()
    {
        return $this->tablename;
    }

    public function getQuery($sql = null)
    {
        $query = mysqli_query($this->conn, $sql);
        return $query;
    }

    public function escapeString($string)
    {
        $escape = mysqli_escape_string($this->conn, $string);
        return $escape;
    }

    public function getWhere($table, $column, $condition, $operand = "and")
    {
        $where_clause = array();
        foreach ($condition as $key => $value) {
            $where_clause[] = $key . " = " . $condition[$key];
        }
        $string_where = implode($operand, $where_clause);
        $string_column = implode("," , $column);
        $sql = "select $string_column from $table where $string_where";
        return $sql;
    }

    public function fetchData($sql, $fetchType = "array")
    {
        $query = $this->getQuery($sql);
        $row = [];
        if ($fetchType == "array") {
            while ($data = mysqli_fetch_array($query)) {
                $row[] = $data;
            }
        } else if ($fetchType == "assoc") {
            while ($data = mysqli_fetch_assoc($query)) {
                $row[] = $data;
            }
        }
        return $row;
    }

    public function fetchRow($sql)
    {
        $query = $this->getQuery($sql);
        $data = mysqli_fetch_assoc($query);
        return $data;
    }

    public function numRows($sql)
    {
        $query = $this->getQuery($sql);
        $data = mysqli_num_rows($query);
        return $data;
    }

    public function getAllData()
    {
        $sql = "SELECT*FROM " . $this->getTableName();
        $row = $this->fetchData($sql, "assoc");
        return $row;
    }

    public function insertRec($table, $data)
    {
        $column = array();
        $values = array();
        foreach ($data as $key => $value) {
            $column[] = $key;
            if (is_integer($data[$key])) {
                $values[] = $data[$key];
            } else if (is_string($data[$key])) {
                $values[] = "'$data[$key]'";
            } else if (is_float($data[$key])) {
                $values[] = $data[$key];
            }
        }
        $string_column = implode(",", $column);
        $string_values = implode(",", $values);
        $sql = "insert into $table ($string_column) values ($string_values)";
        // Maintence::debug($sql);
        $insert = $this->getQuery($sql);
        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function updRec($table, $set_value, $condition, $operand = "and")
    {
        $column_set_value = array();
        $where = array();
        foreach($set_value as $key => $value) {
            $column_set_value[] = $key." = "."'".$set_value[$key]."'";
        }
        foreach($condition as $key => $value) {
            $where[] = $key. " = " .$condition[$key];
        }
        $string_column = implode(",", $column_set_value);
        $string_where = implode($operand, $where);
        $sql = "update $table set $string_column where $string_where";
        // Maintence::debug($sql);
        $update = $this->getQuery($sql);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteRec($table, $condition)
    {
        $where_clause = array();
        foreach ($condition as $key => $value) {
            $where_clause[] = $key . " = " . $condition[$key];
        }
        $string_where = implode(" and ", $where_clause);
        $sql = "delete from $table where $string_where";
        $delete = $this->getQuery($sql);
        if ($delete) {
            return true;
        } else {
            return false;
        }
    }
}
