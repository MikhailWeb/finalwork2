<?php
namespace Base;

class Db
{
    private static $instance;
    private $db;

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function getConnection()
    {
        if (!$this->db) {
            $this->db = new \PDO('mysql:host=localhost;dbname=testdb', 'mysql', 'mysql');
        }
        return $this->db;
    }

    public function fetchAll(string $query, $_method, array $params = [])
    {
        $pdo = $this->getConnection();
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute($params);

        if (!$ret) {
            $errorInfo = $prepared->errorInfo();
            trigger_error("{$errorInfo[0]}#{$errorInfo[1]}: " . $errorInfo[2]);
            return [];
        }

        $data = $prepared->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function fetchOne(string $query, $_method, array $params = [])
    {
        $pdo = $this->getConnection();
        $prepared = $pdo->prepare($query);
        $ret = $prepared->execute($params);

        if (!$ret) {
            $errorInfo = $prepared->errorInfo();
            trigger_error("{$errorInfo[0]}#{$errorInfo[1]}: " . $errorInfo[2]);
            return [];
        }

        $data = $prepared->fetchAll(\PDO::FETCH_ASSOC);
        if (!$data) {
            return false;
        }
        return reset($data);
    }

    public function exec(string $query, array $params = [])
    {
        $pdo = $this->getConnection();
        $prepared = $pdo->prepare($query);
        try {
            $prepared->execute($params);
        } catch (\Exception $e) {
            return false;
        }
        /*if (!$ret) {
            $errorInfo = $prepared->errorInfo();
            trigger_error("{$errorInfo[0]}#{$errorInfo[1]}: " . $errorInfo[2]);
            return -1;
        }*/
        $affectedRows = $prepared->rowCount();
        return $affectedRows;
    }

    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }

}
