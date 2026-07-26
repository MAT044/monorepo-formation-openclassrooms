<?php

class DBConnect {
    public function __construct(
        private string $pilot = 'mysql',
        private string $host = 'localhost',
        private string $port = '3306',
        private string $database = 'database',
        private string $user = 'user',
        private string $password = '',
        private array $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    ) {}

    public function getPDO(): \PDO 
    {
        return new PDO(
            "{$this->pilot}:host={$this->host}:{$this->port};dbname={$this->database}", 
            $this->user, 
            $this->password, 
            $this->options
        );
    }
}