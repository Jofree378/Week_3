<?php
namespace Base;

use PDO;

class Db
{

    /* ПОДКЛЮЧЕНИЕ БД */

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
        $prepared = $this->pdo->prepare($query);
        $ret = $prepared->execute($params);
        $t = microtime(1) - $t;

        if(!$ret) {
            if ($prepared->errorCode()) {
                trigger_error(json_encode($prepared->errorInfo()));
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];

        return $prepared->rowCount();
    }

    public function fetchAll(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $prepared = $this->pdo->prepare($query);
        $ret = $prepared->execute($params);
        $t = microtime(1) - $t;

        if(!$ret) {
            if ($prepared->errorCode()) {
                trigger_error(json_encode($prepared->errorInfo()));
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];

        return $prepared->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $prepared = $this->pdo->prepare($query);
        $ret = $prepared->execute($params);
        $t = microtime(1) - $t;

        if(!$ret) {
            if ($prepared->errorCode()) {
                trigger_error(json_encode($prepared->errorInfo()));
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];

        $result = $prepared->fetchAll(PDO::FETCH_ASSOC);
        if(!$result) {
            return false;
        }
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
