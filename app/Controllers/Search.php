<?php

namespace App\Controllers;

use App\Models\UserModel;

class Search extends BaseController
{
    public function index()
    {
        $query = $this->request->getGet('q');
        $userModel = new UserModel();
        $results = [];

        if ($query) {
            $results = $userModel->searchByUsername(
                trim($query),
                session()->get('userId')
            );
        }

        return view('layout/main', [
            'title' => 'Search Users',
            'content' => view('search_results', [
                'results' => $results,
                'query' => $query,
            ]),
        ]);
    }
}