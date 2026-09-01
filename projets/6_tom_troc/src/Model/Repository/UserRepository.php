<?php

namespace TomTroc\Model\Repository;

use TomTroc\Model\Entity\User;

interface UserRepository {
    public function find(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function create(User $user): User;
    public function update(User $user): User;
    public function delete (int $id): void;
}
