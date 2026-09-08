<?php

namespace TomTroc\Infrastructure\Repository;

use DateTimeImmutable;
use TomTroc\Model\Entity\Message;
use TomTroc\Model\Repository\MessageRepository;
use TomTroc\Model\Repository\UserRepository;

class SessionMessageRepository implements MessageRepository {
	public function __construct(private ?UserRepository $userRepository = null)
	{
		$_SESSION['MESSAGE_TABLE'] ??= ['ROWS' => [], 'AUTO_INCREMENT' => 1];
		$this->userRepository ??= new SessionUserRepository();

		if ($_SESSION['MESSAGE_TABLE']['ROWS'] === []) {
			$this->create(new Message(1, 2, 'Bonjour, ton livre est-il toujours disponible ?', new DateTimeImmutable('2026-02-01 10:00:00'), new DateTimeImmutable('2026-02-01 10:30:00')));
			$this->create(new Message(2, 1, 'Oui, il est toujours disponible.', new DateTimeImmutable('2026-02-01 10:30:00')));
			$this->create(new Message(3, 1, 'Je serais intéressé par Fondation.', new DateTimeImmutable('2026-02-02 14:00:00')));
			$this->create(new Message(1, 3, 'Parfait, je peux te le réserver.', new DateTimeImmutable('2026-02-02 14:15:00'), new DateTimeImmutable('2026-02-02 14:20:00')));
		}
	}

	public function findConversation(int $userA, int $userB): array
	{
		$messages = [];

		foreach ($_SESSION['MESSAGE_TABLE']['ROWS'] as $row) {
			$isConversation = ($row['author_id'] === $userA && $row['target_id'] === $userB)
				|| ($row['author_id'] === $userB && $row['target_id'] === $userA);

			if ($isConversation) {
				$messages[] = $this->toMessage($row);
			}
		}

		usort($messages, fn (Message $first, Message $second) => $first->sendedAt <=> $second->sendedAt);

		return $messages;
	}

	public function findConversationsForUser(int $user): array
	{
		$conversations = [];

		foreach ($_SESSION['MESSAGE_TABLE']['ROWS'] as $row) {
			if ($row['author_id'] !== $user && $row['target_id'] !== $user) {
				continue;
			}

			$otherUserId = $row['author_id'] === $user ? $row['target_id'] : $row['author_id'];
			$message = $this->toMessage($row);

			if (!isset($conversations[$otherUserId])
				|| $conversations[$otherUserId]['lastMessage']->sendedAt < $message->sendedAt) {
				$conversations[$otherUserId] = [
					'user' => $this->userRepository->find($otherUserId),
					'lastMessage' => $message
				];
			}
		}

		usort(
			$conversations,
			fn (array $first, array $second) => $second['lastMessage']->sendedAt <=> $first['lastMessage']->sendedAt
		);

		return $conversations;
	}

	public function create(Message $message): Message
	{
		$id = $_SESSION['MESSAGE_TABLE']['AUTO_INCREMENT']++;

		$_SESSION['MESSAGE_TABLE']['ROWS'][$id] = [
			'author_id' => $message->authorId,
			'target_id' => $message->targetId,
			'body' => $message->body,
			'sended_at' => $message->sendedAt,
			'seen_at' => $message->seenAt
		];

		return $message;
	}

	public function markConversationAsSeen(int $readerId, int $senderId): void
	{
		$seenAt = new DateTimeImmutable();

		foreach ($_SESSION['MESSAGE_TABLE']['ROWS'] as &$row) {
			if ($row['target_id'] === $readerId && $row['author_id'] === $senderId) {
				$row['seen_at'] = $seenAt;
			}
		}
		unset($row);
	}

	public function countUnreadForUser(int $userId): int
	{
		$count = 0;

		foreach ($_SESSION['MESSAGE_TABLE']['ROWS'] as $row) {
			if ($row['target_id'] === $userId && ($row['seen_at'] ?? null) === null) {
				$count++;
			}
		}

		return $count;
	}

	private function toMessage(array $row): Message
	{
		return new Message(
			$row['author_id'],
			$row['target_id'],
			$row['body'],
			$row['sended_at'],
			$row['seen_at'] ?? null
		);
	}
}