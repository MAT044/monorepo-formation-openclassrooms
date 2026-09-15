<?php

namespace TomTroc\Infrastructure\Repository;

use DateTimeImmutable;
use TomTroc\Core\DB\DB;
use TomTroc\Model\Entity\Message;
use TomTroc\Model\Repository\MessageRepository;
use TomTroc\Model\Repository\UserRepository;

class DbMessageRepository implements MessageRepository
{
    public function __construct(
        private readonly DB $db,
        private readonly ?UserRepository $userRepository = null
    ) {
    }

    public function findConversation(int $userA, int $userB): array
    {
        $rows = $this->db->run(
            'SELECT * FROM messages
            WHERE (author_id = :author_a AND target_id = :target_b)
               OR (author_id = :author_b AND target_id = :target_a)
            ORDER BY sended_at ASC',
            [
                'author_a' => $userA,
                'target_a' => $userA,
                'author_b' => $userB,
                'target_b' => $userB,
            ]
        )->fetchAll();

        return array_map(fn (array $row) => $this->hydrate($row), $rows);
    }

    public function findConversationsForUser(int $user): array
    {
        $rows = $this->db->run(
            'SELECT m.*
            FROM messages m
            WHERE m.author_id = :author_id OR m.target_id = :target_id
            ORDER BY m.sended_at DESC',
            ['author_id' => $user, 'target_id' => $user]
        )->fetchAll();

        $conversations = [];

        foreach ($rows as $row) {
            $otherUserId = (int) $row['author_id'] === $user ? (int) $row['target_id'] : (int) $row['author_id'];

            if (!isset($conversations[$otherUserId])) {
                $conversations[$otherUserId] = [
                    'user' => $this->userRepository?->find($otherUserId),
                    'lastMessage' => $this->hydrate($row),
                ];
                continue;
            }

            if ($conversations[$otherUserId]['lastMessage']->sendedAt < new DateTimeImmutable($row['sended_at'])) {
                $conversations[$otherUserId]['lastMessage'] = $this->hydrate($row);
            }
        }

        $conversations = array_values($conversations);
        usort(
            $conversations,
            fn (array $first, array $second) => $second['lastMessage']->sendedAt <=> $first['lastMessage']->sendedAt
        );

        return $conversations;
    }

    public function create(Message $message)
    {
        $this->db->run(
            'INSERT INTO messages (author_id, target_id, body, sended_at, seen_at)
            VALUES (:author_id, :target_id, :body, :sended_at, :seen_at)',
            [
                'author_id' => $message->authorId,
                'target_id' => $message->targetId,
                'body' => $message->body,
                'sended_at' => $message->sendedAt->format('Y-m-d H:i:s'),
                'seen_at' => $message->seenAt?->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function markConversationAsSeen(int $readerId, int $senderId): void
    {
        $this->db->run(
            'UPDATE messages
            SET seen_at = NOW()
            WHERE target_id = :reader_id AND author_id = :sender_id AND seen_at IS NULL',
            [
                'reader_id' => $readerId,
                'sender_id' => $senderId,
            ]
        );
    }

    public function countUnreadForUser(int $userId): int
    {
        $row = $this->db->run(
            'SELECT COUNT(*) AS total FROM messages WHERE target_id = :user_id AND seen_at IS NULL',
            ['user_id' => $userId]
        )->fetch();

        return (int) ($row['total'] ?? 0);
    }

    private function hydrate(array $row): Message
    {
        return new Message(
            (int) $row['author_id'],
            (int) $row['target_id'],
            $row['body'],
            new DateTimeImmutable($row['sended_at']),
            isset($row['seen_at']) && $row['seen_at'] !== null
                ? new DateTimeImmutable($row['seen_at'])
                : null
        );
    }
}
