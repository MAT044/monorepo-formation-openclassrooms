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
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_map(
            fn(array $row) => $this->mapRowToEntity($row),
            $rows
        );
    }

    public function mapRowToEntity(array $row): Contact
    {
        return new Contact(
            $row['id'],
            $row['name'],
            $row['email'],
            $row['phone_number']
        );
    }
}