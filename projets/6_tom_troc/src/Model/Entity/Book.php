<?php

namespace TomTroc\Model\Entity;

use DateTimeImmutable;

readonly class Book {
    public function __construct(
        public ?int $id,
        public string $title,
        public string $author,
        public string $description,
        public bool $available,
        public DateTimeImmutable $createdAt,
        public int $ownerId,
        public ?string $illustrationUri,
    )
    {}

    public function withId(int $id) {
        return new Book(
            $id,
            $this->title,
            $this->author,
            $this->description,
            $this->available,
            $this->createdAt,
            $this->ownerId,
            $this->illustrationUri
        );
    }

    public function update(
        string $title,
        string $author,
        string $description,
        bool $available
    ) {
        return new Book(
            $this->id,
            $title,
            $author,
            $description,
            $available,
            $this->createdAt,
            $this->ownerId,
            $this->illustrationUri
        );
    }
}