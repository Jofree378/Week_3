<?php
namespace Base;

use PDO;

class Db
{
    private static $instance;
    private $pdo;
    private $log = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function connect(): PDO
    {
        $host = DB_HOST;
        $dbName = DB_NAME;
        $dbUser = DB_USER;
        $dbPassword = DB_PASSWORD;

        if (!$this->pdo) {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbUser, $dbPassword);
        }

        return $this->pdo;
    }

    public function exec(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);
        $t = microtime(1) - $t;

        if(!$ret) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];

        return $query->rowCount();
    }

    public function fetchAll(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);
        $t = microtime(1) - $t;

        if(!$ret) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);
        $t = microtime(1) - $t;

        if(!$ret) {
            if ($query->errorCode()) {
                trigger_error(json_encode($query->errorInfo()));
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return reset($result);
    }

    public function lastInsertId()
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }

    public function getLog()
    {
        if (!$this->log) {
            return '';
        }
        $res = '';
        foreach ($this->log as $element){
            $res = $element[1] . ': ' . $element[0] . ' (' . $element[2] . ') [' . $element[3] . ']' . "\n";
        }
        return "<pre>" . $res . "</pre>";
    }

}
