<?php

class ContactManager 
{
    public function __construct(
        private readonly \PDO $pdo
    )
    {}

    public function findAll(): array
    {
        $statement = $this->pdo->query("SELECT * FROM contact WHERE 1;");
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}