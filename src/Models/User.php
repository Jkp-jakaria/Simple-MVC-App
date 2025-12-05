<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $passwordHash;

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByEmail(string $email): ?self
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        $user = new self($this->db);
        $user->id = (int) $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->passwordHash = $data['password_hash'];

        return $user;
    }

    public function create(string $name, string $email, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password_hash, created_at) 
                VALUES (:name, :email, :password_hash, NOW())'
        );

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $hash
        ]);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }
}
