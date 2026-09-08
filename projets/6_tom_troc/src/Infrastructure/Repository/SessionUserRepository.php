<?php

namespace TomTroc\Infrastructure\Repository;

use DateTimeImmutable;
use TomTroc\Model\Entity\User;
use TomTroc\Model\Repository\UserRepository;

class SessionUserRepository implements UserRepository
{
    public function __construct()
    {
        $_SESSION['USER_TABLE'] ??= ['ROWS' => [], 'AUTO_INCREMENT' => 1];

        if ($_SESSION['USER_TABLE']['ROWS'] === []) {
            $passwordHash = password_hash('test', PASSWORD_DEFAULT);

            $this->create(new User(null, 'test@example.com', $passwordHash, 'test', new DateTimeImmutable('2026-01-01'), null));
            $this->create(new User(null, 'test2@example.com', $passwordHash, 'test2', new DateTimeImmutable('2026-01-02'), null));
            $this->create(new User(null, 'test3@example.com', $passwordHash, 'test3', new DateTimeImmutable('2026-01-03'), null));
        }
    }

    public function find(int $id): ?User
    {
        $row = $_SESSION['USER_TABLE']['ROWS'][$id] ?? null;

        if ($row === null) {
            return null;
        }

        return new User(
            $row['id'],
            $row['email'],
            $row['password_hash'],
            $row['username'],
            $row['registered_at'],
            $row['avatar_uri']
        );
    }

    public function findByEmail(string $email): ?User
    {
        $rows = $_SESSION['USER_TABLE']['ROWS'];

        foreach ($rows as $row) {
            if ($row['email'] === $email) {
                return new User(
                    $row['id'],
                    $row['email'],
                    $row['password_hash'],
                    $row['username'],
                    $row['registered_at'],
                    $row['avatar_uri']
                );
            }
        }

        return null;
    }

    public function create(User $user): User
    {
        $id = $_SESSION['USER_TABLE']['AUTO_INCREMENT']++;

        $user = $user->withId($id);

        $_SESSION['USER_TABLE']['ROWS'][$id] = [
            'id' => $user->id,
            'email' => $user->email,
            'password_hash' => $user->passwordHash,
            'username' => $user->username,
            'registered_at' => $user->registeredAt,
            'avatar_uri' => $user->avatarUri
        ];

        return $user;
    }

    public function update(User $user): User
    {
        $id = $user->id;

        $_SESSION['USER_TABLE']['ROWS'][$id] = [
            'id' => $user->id,
            'email' => $user->email,
            'password_hash' => $user->passwordHash,
            'username' => $user->username,
            'registered_at' => $user->registeredAt,
            'avatar_uri' => $user->avatarUri
        ];

        return $user;
    }

    public function delete(int $id): void
    {
        unset($_SESSION['USER_TABLE']['ROWS'][$id]);
    }
}