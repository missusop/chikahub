<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'first_name',
        'last_name',
        'dob',
        'sex',
        'email',
        'password',
        'profile_pic',
    ];
    protected $useTimestamps = true;

    // ─── Authentication ────────────────────────────────────────────────────────

    /**
     * Find a user by email and verify password.
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Register a new user with a hashed password.
     */
    public function register(array $data): int|false
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['profile_pic'] = 'default.png';

        return $this->insert($data);
    }

    // ─── Lookups ───────────────────────────────────────────────────────────────

    public function emailExists(string $email): bool
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }

    public function usernameExists(string $username): bool
    {
        return $this->where('username', $username)->countAllResults() > 0;
    }

    /**
     * Search users by username (partial, excludes self).
     */
    public function searchByUsername(string $query, int $excludeId): array
    {
        return $this->like('username', $query)
            ->where('id !=', $excludeId)
            ->findAll();
    }

    public function getUserById(int $id): ?array
    {
        return $this->find($id);
    }
}