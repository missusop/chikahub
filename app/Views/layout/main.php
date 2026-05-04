<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SocialApp') ?> — SocialApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

<?php if (session()->get('isLoggedIn')): ?>
<!-- ─── Navbar ──────────────────────────────────────────────────────────────── -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?= base_url('/feed') ?>">
            <i class="bi bi-stars me-1"></i>SocialApp
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <!-- Search -->
            <form class="d-flex mx-auto" action="<?= base_url('/search') ?>" method="get">
                <div class="input-group">
                    <input class="form-control form-control-sm" type="search" name="q"
                           placeholder="Search users…" style="min-width:220px;">
                    <button class="btn btn-light btn-sm" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Nav Links -->
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/feed') ?>">
                        <i class="bi bi-house-door-fill me-1"></i>Feed
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/profile/' . session()->get('userId')) ?>">
                        <img src="<?= base_url('uploads/' . session()->get('profilePic')) ?>"
                             class="rounded-circle me-1" width="28" height="28"
                             style="object-fit:cover;" alt="avatar">
                        <?= esc(session()->get('firstName')) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="<?= base_url('/logout') ?>">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>

<!-- ─── Flash Messages ──────────────────────────────────────────────────────── -->
<div class="container mt-3">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>

<!-- ─── Main Content ────────────────────────────────────────────────────────── -->
<main class="container my-4">
    <?= $content ?? '' ?>
</main>

<footer class="text-center text-muted py-4 mt-5 border-top">
    <small>&copy; <?= date('Y') ?> SocialApp. Built with CodeIgniter 4.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>