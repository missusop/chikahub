<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ─── Public Routes (No Login Required) ───────────────────────────────────────
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerUser');
$routes->get('/logout', 'Auth::logout');

// ─── Protected Routes (Login Required — guarded by AuthFilter) ────────────────
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Feed
    $routes->get('/feed', 'Feed::index');
    $routes->post('/feed/create', 'Feed::create');
    $routes->post('/feed/delete/(:num)', 'Feed::delete/$1');

    // Profile
    $routes->get('/profile/(:num)', 'Profile::index/$1');
    $routes->post('/profile/update', 'Profile::update');
    $routes->post('/profile/upload', 'Profile::uploadPicture');

    // Follow / Unfollow
    $routes->post('/follow/(:num)', 'Profile::follow/$1');
    $routes->post('/unfollow/(:num)', 'Profile::unfollow/$1');

    // Search
    $routes->get('/search', 'Search::index');
});