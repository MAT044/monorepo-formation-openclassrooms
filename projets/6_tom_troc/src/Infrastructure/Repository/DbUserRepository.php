<?php

namespace TomTroc\Infrastructure\Repository;

use DateTimeImmutable;
use TomTroc\Core\DB\DB;
use TomTroc\Model\Entity\User;
use TomTroc\Model\Repository\UserRepository;

class DbUserRepository implements UserRepository
{
    public function __construct(private readonly DB $db)
    {
    }

    public function find(int $id): ?User
    {
        $row = $this->db->run(
            'SELECT * FROM users WHERE id = :id LIMIT 1',
            ['id' => $id]
        )->fetch();

        if ($row === false) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function findByEmail(string $email): ?User
    {
        $row = $this->db->run(
            'SELECT * FROM users WHERE email = :email LIMIT 1',
            ['email' => $email]
        )->fetch();

        if ($row === false) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function create(User $user): User
    {
        $stmt = $this->db->run(
            'INSERT INTO users (email, password_hash, username, registered_at, avatar_uri)
            VALUES (:email, :password_hash, :username, :registered_at, :avatar_uri)',
            [
                'email' => $user->email,
                'password_hash' => $user->passwordHash,
                'username' => $user->username,
                'registered_at' => $user->registeredAt->format('Y-m-d H:i:s'),
                'avatar_uri' => $user->avatarUri,
            ]
        );

        $id = (int) $this->db->pdo->lastInsertId();

        return $user->withId($id);
    }

    public function update(User $user): User
    {
        $this->db->run(
            'UPDATE users
            SET email = :email,
                password_hash = :password_hash,
                username = :username,
                avatar_uri = :avatar_uri
            WHERE id = :id',
            [
                'id' => $user->id,
                'email' => $user->email,
                'password_hash' => $user->passwordHash,
                'username' => $user->username,
                'avatar_uri' => $user->avatarUri,
            ]
        );

        return $user;
    }

    public function delete(int $id): void
    {
        $this->db->run(
            'DELETE FROM users WHERE id = :id',
            ['id' => $id]
        );
    }

    private function hydrate(array $row): User
    {
        return new User(
            (int) $row['id'],
            $row['email'],
            $row['password_hash'],
            $row['username'],
            new DateTimeImmutable($row['registered_at']),
            $row['avatar_uri']
        );
    }
}
