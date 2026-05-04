<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // ─── Login Page ────────────────────────────────────────────────────────────

    public function index()
    {
        if (session()->get('isLoggedIn'))
            return redirect()->to('/feed');

        return view('layout/main', [
            'title' => 'Login',
            'content' => view('auth/login'),
        ]);
    }

    // ─── Handle Login ──────────────────────────────────────────────────────────

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->authenticate(
            $this->request->getPost('email'),
            $this->request->getPost('password')
        );

        if (!$user) {
            return redirect()->back()->withInput()
                ->with('error', 'Invalid email or password.');
        }

        session()->set([
            'isLoggedIn' => true,
            'userId' => $user['id'],
            'username' => $user['username'],
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
            'profilePic' => $user['profile_pic'],
        ]);

        return redirect()->to('/feed');
    }

    // ─── Register Page ─────────────────────────────────────────────────────────

    public function register()
    {
        if (session()->get('isLoggedIn'))
            return redirect()->to('/feed');

        return view('layout/main', [
            'title' => 'Register',
            'content' => view('auth/register'),
        ]);
    }

    // ─── Handle Register ───────────────────────────────────────────────────────

    public function registerUser()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'dob' => 'required|valid_date',
            'sex' => 'required|in_list[Male,Female,Other]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->register([
            'username' => $this->request->getPost('username'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'dob' => $this->request->getPost('dob'),
            'sex' => $this->request->getPost('sex'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);

        return redirect()->to('/login')
            ->with('success', 'Account created! Please log in.');
    }

    // ─── Logout ────────────────────────────────────────────────────────────────

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}