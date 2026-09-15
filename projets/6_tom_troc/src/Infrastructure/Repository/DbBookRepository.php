<?php

namespace TomTroc\Infrastructure\Repository;

use DateTimeImmutable;
use TomTroc\Core\DB\DB;
use TomTroc\Model\Entity\Book;
use TomTroc\Model\Repository\BookRepository;

class DbBookRepository implements BookRepository
{
    public function __construct(private readonly DB $db)
    {
    }

    public function find(int $id): ?Book
    {
        $row = $this->db->run(
            'SELECT * FROM books WHERE id = :id LIMIT 1',
            ['id' => $id]
        )->fetch();

        if ($row === false) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function findBySearch(string $title): array
    {
        $sql = 'SELECT * FROM books WHERE title LIKE :title';
        $rows = $this->db->run($sql, [
            'title' => '%' . $title . '%'
        ])->fetchAll();

        return array_map(fn (array $row) => $this->hydrate($row), $rows);
    }

    public function findByUser(int $userId): array
    {
        $rows = $this->db->run(
            'SELECT * FROM books WHERE owner_id = :owner_id ORDER BY created_at DESC',
            ['owner_id' => $userId]
        )->fetchAll();

        return array_map(fn (array $row) => $this->hydrate($row), $rows);
    }

    public function findLastest(int $max): array
    {
        $rows = $this->db->run(
            'SELECT * FROM books ORDER BY created_at DESC LIMIT :limit',
            ['limit' => $max]
        )->fetchAll();

        return array_map(fn (array $row) => $this->hydrate($row), $rows);
    }

    public function create(Book $book): Book
    {
        $stmt = $this->db->run(
            'INSERT INTO books (title, author, description, available, created_at, owner_id, illustration_uri)
            VALUES (:title, :author, :description, :available, :created_at, :owner_id, :illustration_uri)',
            [
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description,
                'available' => $book->available ? 1 : 0,
                'created_at' => $book->createdAt->format('Y-m-d H:i:s'),
                'owner_id' => $book->owner->id,
                'illustration_uri' => $book->illustrationUri,
            ]
        );

        $id = (int) $this->db->pdo->lastInsertId();

        return $book->withId($id);
    }

    public function update(Book $book): Book
    {
        $this->db->run(
            'UPDATE books
            SET title = :title,
                author = :author,
                description = :description,
                available = :available,
                illustration_uri = :illustration_uri,
                owner_id = :owner_id
            WHERE id = :id',
            [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description,
                'available' => $book->available ? 1 : 0,
                'illustration_uri' => $book->illustrationUri,
                'owner_id' => $book->owner->id,
            ]
        );

        return $book;
    }

    public function upsert(Book $book): Book
    {
        if ($book->id === null) {
            return $this->create($book);
        }

        return $this->update($book);
    }

    public function delete(int $id): void
    {
        $this->db->run(
            'DELETE FROM books WHERE id = :id',
            ['id' => $id]
        );
    }

    private function hydrate(array $row): Book
    {
        $owner = $this->db->run(
            'SELECT * FROM users WHERE id = :id LIMIT 1',
            ['id' => (int) $row['owner_id']]
        )->fetch();

        if ($owner === false) {
            $owner = [
                'id' => (int) $row['owner_id'],
                'email' => 'unknown@example.com',
                'password_hash' => '',
                'username' => 'unknown',
                'registered_at' => date('Y-m-d H:i:s'),
                'avatar_uri' => null,
            ];
        }

        return new Book(
            (int) $row['id'],
            $row['title'],
            $row['author'],
            $row['description'],
            (bool) $row['available'],
            new DateTimeImmutable($row['created_at']),
            new \TomTroc\Model\Entity\User(
                (int) $owner['id'],
                $owner['email'],
                $owner['password_hash'],
                $owner['username'],
                new DateTimeImmutable($owner['registered_at']),
                $owner['avatar_uri']
            ),
            $row['illustration_uri']
        );
    }
}
