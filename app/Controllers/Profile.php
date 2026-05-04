<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\FollowModel;

class Profile extends BaseController
{
    public function index(int $userId)
    {
        $userModel = new UserModel();
        $postModel = new PostModel();
        $followModel = new FollowModel();

        $profileUser = $userModel->getUserById($userId);
        if (!$profileUser) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User #$userId not found.");
        }

        return view('layout/main', [
            'title' => $profileUser['first_name'] . "'s Profile",
            'content' => view('profile', [
                'profileUser' => $profileUser,
                'posts' => $postModel->getPostsByUser($userId),
                'followerCount' => $followModel->getFollowerCount($userId),
                'followingCount' => $followModel->getFollowingCount($userId),
                'isFollowing' => $followModel->isFollowing(session()->get('userId'), $userId),
            ]),
        ]);
    }

    // ─── Update Bio (we'll use the username field as bio isn't in schema, ─────
    // ─── but we CAN update first_name / last_name) ─────────────────────────────

    public function update()
    {
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('userId');
        $userModel = new UserModel();
        $userModel->update($userId, [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
        ]);

        // Refresh session values
        session()->set([
            'firstName' => $this->request->getPost('first_name'),
            'lastName' => $this->request->getPost('last_name'),
        ]);

        return redirect()->to('/profile/' . $userId)->with('success', 'Profile updated!');
    }

    // ─── Upload Profile Picture ────────────────────────────────────────────────

    public function uploadPicture()
    {
        $file = $this->request->getFile('profile_pic');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'No valid file uploaded.');
        }

        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowed)) {
            return redirect()->back()->with('error', 'Only image files are allowed.');
        }

        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads', $newName);

        $userId = session()->get('userId');
        $userModel = new UserModel();
        $userModel->update($userId, ['profile_pic' => $newName]);

        session()->set('profilePic', $newName);

        return redirect()->to('/profile/' . $userId)->with('success', 'Profile picture updated!');
    }

    // ─── Follow / Unfollow ────────────────────────────────

    public function follow(int $userId)
    {
        (new FollowModel())->follow(session()->get('userId'), $userId);
        return redirect()->to('/profile/' . $userId);
    }

    public function unfollow(int $userId)
    {
        (new FollowModel())->unfollow(session()->get('userId'), $userId);
        return redirect()->to('/profile/' . $userId);
    }
}