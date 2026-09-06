<?php

namespace TomTroc\Infrastructure\Repository;

use DateTimeImmutable;
use TomTroc\Model\Entity\Book;
use TomTroc\Model\Repository\BookRepository;

class SessionBookRepository implements BookRepository
{
    public function __construct()
    {
        $_SESSION['BOOK_TABLE'] ??= ['ROWS' => [], 'AUTO_INCREMENT' => 0];
    }

    public function find(int $id): ?Book
    {
        $row = $_SESSION['BOOK_TABLE']['ROWS'][$id] ?? null;

        if ($row === null) {
            return null;
        }

        return new Book(
            $row['id'],
            $row['title'],
            $row['author'],
            $row['description'],
            $row['available'],
            $row['created_at'],
            $row['owner_id'],
            $row['illustration_uri']
        );
    }

    public function findBySearch(string $title, bool $available): array
    {
        $rows = $_SESSION['BOOK_TABLE']['ROWS'];
        $result = [];

        foreach ($rows as $row) {
            if (stripos($row['title'], $title) !== false && $row['available'] === $available) {
                $result[] = new Book(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    $row['description'],
                    $row['available'],
                    $row['created_at'],
                    $row['owner_id'],
            $row['illustration_uri']
                );
            }
        }

        return $result;
    }

    public function findByUser(int $userId): array
    {
        $rows = $_SESSION['BOOK_TABLE']['ROWS'];
        $result = [];

        foreach ($rows as $row) {
            if ($row['owner_id'] === $userId) {
                $result[] = new Book(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    $row['description'],
                    $row['available'],
                    $row['created_at'],
                    $row['owner_id'],
            $row['illustration_uri']
                );
            }
        }

        return $result;
    }

    public function create(Book $book): Book
    {
        $id = $_SESSION['BOOK_TABLE']['AUTO_INCREMENT']++;

        $book = $book->withId($id);

        $_SESSION['BOOK_TABLE']['ROWS'][$id] = [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'description' => $book->description,
            'available' => $book->available,
            'created_at' => $book->createdAt,
            'owner_id' => $book->ownerId,
            'illustration_uri' => $book->illustrationUri
        ];

        return $book;
    }

    public function update(Book $book): Book
    {
        $id = $book->id;

        $_SESSION['BOOK_TABLE']['ROWS'][$id] = [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'description' => $book->description,
            'available' => $book->available,
            'created_at' => $book->createdAt,
            'owner_id' => $book->ownerId,
            'illustration_uri' => $book->illustrationUri
        ];

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
        unset($_SESSION['BOOK_TABLE']['ROWS'][$id]);
    }
}