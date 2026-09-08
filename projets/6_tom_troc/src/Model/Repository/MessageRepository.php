<?php

namespace TomTroc\Model\Repository;

use TomTroc\Model\Entity\Message;

interface MessageRepository {
    /**
     * Retrieve all messages from a conversations between two users, ordered by sendedAt
     * @param int $userA
     * @param int $userB
     * @return void
     */
    public function findConversation(int $userA, int $userB): array;

    /**
     * Retrieve all conversations for a user. 
     * Each conversation return the other user name and url and the last message from the conversation
     * @param int $user
     * @return void
     */
    public function findConversationsForUser(int $user): array;

    public function create(Message $message);

    public function markConversationAsSeen(int $readerId, int $senderId): void;

    public function countUnreadForUser(int $userId): int;
}