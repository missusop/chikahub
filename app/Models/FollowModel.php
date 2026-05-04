<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowModel extends Model
{
    protected $table = 'follows';
    protected $primaryKey = ['follower_id', 'following_id']; // composite PK
    protected $allowedFields = ['follower_id', 'following_id'];
    protected $useTimestamps = false;   // only created_at, no updated_at

    /**
     * Follow a user. Composite PK handles duplicate prevention at DB level,
     * but we guard here too.
     */
    public function follow(int $followerId, int $followingId): bool
    {
        if ($followerId === $followingId)
            return false;

        if ($this->isFollowing($followerId, $followingId))
            return false;

        return (bool) $this->db->table('follows')->insert([
            'follower_id' => $followerId,
            'following_id' => $followingId,
        ]);
    }

    public function unfollow(int $followerId, int $followingId): bool
    {
        return (bool) $this->db->table('follows')
            ->where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->delete();
    }

    public function isFollowing(int $followerId, int $followingId): bool
    {
        return $this->db->table('follows')
            ->where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->countAllResults() > 0;
    }

    public function getFollowerCount(int $userId): int
    {
        return $this->db->table('follows')
            ->where('following_id', $userId)
            ->countAllResults();
    }

    public function getFollowingCount(int $userId): int
    {
        return $this->db->table('follows')
            ->where('follower_id', $userId)
            ->countAllResults();
    }
}