<?php

namespace TomTroc\Infrastructure\Repository;

use DateTimeImmutable;
use TomTroc\Model\Entity\User;
use TomTroc\Model\Repository\UserRepository;

class SessionUserRepository implements UserRepository
{
    public function __construct()
    {
        $_SESSION['USER_TABLE'] ??= ['ROWS' => [], 'AUTO_INCREMENT' => 0];
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
            $row['registered_at']
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
                    $row['registered_at']
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
            'registered_at' => $user->registeredAt
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
            'registered_at' => $user->registeredAt
        ];

        return $user;
    }

    public function delete(int $id): void
    {
        unset($_SESSION['USER_TABLE']['ROWS'][$id]);
    }
}