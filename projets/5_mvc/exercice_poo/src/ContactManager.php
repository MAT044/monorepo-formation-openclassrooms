<?php

class ContactManager
{
    public function __construct(
        private readonly \PDO $pdo
    ) {
    }

    public function insert(Contact $contact): void
    {
        $statement = $this->pdo->prepare("INSERT INTO contact (name, email, phone_number) VALUES (?, ?, ?);");
        $statement->execute([
            $contact->getName(),
            $contact->getEmail(),
            $contact->getPhoneNumber()
        ]);
        $contact->setId((int)$this->pdo->lastInsertId());
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query("SELECT * FROM contact WHERE 1;");
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            fn(array $row) => $this->mapRowToEntity($row),
            $rows
        );
    }

    public function find(int $id): ?Contact
    {
        $statement = $this->pdo->prepare("SELECT * FROM contact WHERE id = ?;");
        $statement->execute([$id]);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if (empty($row)) {
            return null;
        }
        return $this->mapRowToEntity($row);
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