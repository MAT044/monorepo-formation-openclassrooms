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
        public User $owner,
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
            $this->owner,
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
            $this->owner,
            $this->illustrationUri
        );
    }

    public function updateIllustration(string $uri): self
    {
        return new Book(
            $this->id,
            $this->title,
            $this->author,
            $this->description,
            $this->available,
            $this->createdAt,
            $this->owner,
            $uri
        );
    }
}