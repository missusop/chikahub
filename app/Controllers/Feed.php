<?php

namespace App\Controllers;

use App\Models\PostModel;

class Feed extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();
        $posts = $postModel->getFeed(session()->get('userId'));

        return view('layout/main', [
            'title' => 'Feed',
            'content' => view('feed', ['posts' => $posts]),
        ]);
    }

    public function create()
    {
        $rules = ['content' => 'required|max_length[1000]'];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $postModel = new PostModel();
        $postModel->createPost(
            session()->get('userId'),
            $this->request->getPost('content')
        );

        return redirect()->to('/feed')->with('success', 'Post created!');
    }

    public function delete(int $postId)
    {
        $postModel = new PostModel();
        $postModel->deletePost($postId, session()->get('userId'));
        return redirect()->to('/feed')->with('success', 'Post deleted.');
    }
}