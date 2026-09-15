<?php

namespace TomTroc\Model\Repository;

use TomTroc\Model\Entity\Book;

interface BookRepository {
    public function find(int $id): ?Book;
    public function findBySearch(string $title): array;
    public function findByUser(int $userId): array;

    public function findLastest(int $max): array;

    public function create(Book $book): Book;
    public function update(Book $book): Book;
    public function upsert(Book $book): Book;
    public function delete (int $id): void;
}