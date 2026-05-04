<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <h5 class="fw-bold mb-4">
            <i class="bi bi-search me-2 text-primary"></i>
            <?php if ($query): ?>
                Results for "<span class="text-primary">
                    <?= esc($query) ?>
                </span>"
            <?php else: ?>
                Search Users
            <?php endif; ?>
        </h5>

        <!-- Search Form -->
        <form action="<?= base_url('/search') ?>" method="get" class="mb-4">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Search by username…"
                    value="<?= esc($query ?? '') ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Results -->
        <?php if ($query && empty($results)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x display-4"></i>
                <h5 class="mt-3">No users found</h5>
                <p>Try a different username.</p>
            </div>

        <?php elseif (!empty($results)): ?>
            <?php foreach ($results as $user): ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body d-flex align-items-center gap-3">
                        <a href="<?= base_url('/profile/' . $user['id']) ?>">
                            <img src="<?= base_url('uploads/' . $user['profile_pic']) ?>" class="rounded-circle" width="52"
                                height="52" style="object-fit:cover;" alt="avatar">
                        </a>
                        <div class="flex-grow-1">
                            <a href="<?= base_url('/profile/' . $user['id']) ?>" class="fw-bold text-dark text-decoration-none">
                                <?= esc($user['first_name'] . ' ' . $user['last_name']) ?>
                            </a>
                            <div class="text-muted small">@
                                <?= esc($user['username']) ?>
                            </div>
                        </div>
                        <a href="<?= base_url('/profile/' . $user['id']) ?>" class="btn btn-outline-primary btn-sm">
                            View Profile
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people display-4"></i>
                <p class="mt-3">Enter a username to find people.</p>
            </div>
        <?php endif; ?>

    </div>
</div>