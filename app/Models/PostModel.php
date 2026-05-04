<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'content'];
    protected $useTimestamps = false;   // schema only has created_at, no updated_at

    /**
     * Feed: posts from self + people the user follows, newest first.
     */
    public function getFeed(int $userId): array
    {
        // Get IDs of people this user follows
        $followingIds = $this->db->table('follows')
            ->select('following_id')
            ->where('follower_id', $userId)
            ->get()
            ->getResultArray();

        $ids = array_column($followingIds, 'following_id');
        $ids[] = $userId; // include own posts

        return $this->db->table('posts p')
            ->select('p.*, u.username, u.first_name, u.last_name, u.profile_pic')
            ->join('users u', 'u.id = p.user_id')
            ->whereIn('p.user_id', $ids)
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * All posts by a specific user for their profile page.
     */
    public function getPostsByUser(int $userId): array
    {
        return $this->db->table('posts p')
            ->select('p.*, u.username, u.first_name, u.last_name, u.profile_pic')
            ->join('users u', 'u.id = p.user_id')
            ->where('p.user_id', $userId)
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function createPost(int $userId, string $content): int|false
    {
        return $this->insert([
            'user_id' => $userId,
            'content' => $content,
        ]);
    }

    /**
     * Delete a post only if it belongs to the requesting user.
     */
    public function deletePost(int $postId, int $userId): bool
    {
        return $this->where('id', $postId)
            ->where('user_id', $userId)
            ->delete();
    }
}