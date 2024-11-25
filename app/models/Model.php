<?php

namespace app\models;

use PDO;
use PDOException;

abstract class Model {
    private function connect() {
        $type = 'mysql';
        $charset = 'utf8mb4';
        $dsn = "$type:host=" . DBHOST . ";dbname=" . DBNAME . ";port=" . DBPORT . ";charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            return new PDO($dsn, DBUSER, DBPASS, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function fetchAll($query) {
        $pdo = $this->connect();
        $stmt = $pdo->query($query);
        return $stmt->fetchAll();
    }

    public function execute($query, $params = []) {
        $pdo = $this->connect();
        $stmt = $pdo->prepare($query);
        return $stmt->execute($params);
    }
}
