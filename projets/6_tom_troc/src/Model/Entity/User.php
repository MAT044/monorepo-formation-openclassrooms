<?php

namespace TomTroc\Model\Entity;

use DateTimeImmutable;

readonly class User {
    public function __construct(
        public ?int $id,
        public string $email,
        public string $passwordHash,
        public string $username,
        public DateTimeImmutable $registeredAt,
    ){}
}