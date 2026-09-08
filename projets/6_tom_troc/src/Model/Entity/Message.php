<?php

namespace TomTroc\Model\Entity;

use DateTimeImmutable;

readonly class Message {
    public function __construct(
        public int $authorId,
        public int $targetId,
        public string $body,
        public DateTimeImmutable $sendedAt,
        public ?DateTimeImmutable $seenAt = null
    ){}
}