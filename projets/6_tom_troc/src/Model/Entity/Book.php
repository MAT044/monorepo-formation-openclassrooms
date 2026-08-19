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
    )
    {}
}