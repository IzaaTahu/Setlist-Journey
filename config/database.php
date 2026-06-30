<?php

class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    private string $host     = 'localhost';
    private string $dbname   = 'setlist_journey1';
    private string $username = 'root';          // ganti sesuai hosting
    private string $password = '';              // ganti sesuai hosting
    private string $charset  = 'utf8mb4';

    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // Jangan expose error detail di production
            error_log($e->getMessage());
            die("Koneksi database gagal. Silakan coba beberapa saat lagi.");
        }
    }

    public static function getInstance(): static {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}
