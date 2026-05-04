<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">

        <!-- ─── Create Post ───────────────────────────────────────────────────── -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                <form action="<?= base_url('/feed/create') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="d-flex gap-3 align-items-start">
                        <img src="<?= base_url('uploads/' . session()->get('profilePic')) ?>" class="rounded-circle"
                            width="44" height="44" style="object-fit:cover;flex-shrink:0;" alt="avatar">
                        <textarea name="content" class="form-control border-0 bg-light" rows="3"
                            placeholder="What's on your mind, <?= esc(session()->get('firstName')) ?>?" required
                            maxlength="1000"></textarea>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-send me-1"></i>Post
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ─── Feed Posts ────────────────────────────────────────────────────── -->
        <?php if (empty($posts)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-newspaper display-3"></i>
                <h5 class="mt-3">Your feed is empty</h5>
                <p>Follow people to see their posts here.</p>
                <a href="<?= base_url('/search') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-search me-1"></i>Find People
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <!-- Author Row -->
                        <div class="d-flex align-items-center mb-3">
                            <a href="<?= base_url('/profile/' . $post['user_id']) ?>">
                                <img src="<?= base_url('uploads/' . $post['profile_pic']) ?>" class="rounded-circle me-2"
                                    width="42" height="42" style="object-fit:cover;" alt="avatar">
                            </a>
                            <div>
                                <a href="<?= base_url('/profile/' . $post['user_id']) ?>"
                                    class="fw-bold text-dark text-decoration-none">
                                    <?= esc($post['first_name'] . ' ' . $post['last_name']) ?>
                                </a>
                                <span class="text-muted small ms-1">@
                                    <?= esc($post['username']) ?>
                                </span>
                                <div class="text-muted small">
                                    <?= date('M j, Y · g:i A', strtotime($post['created_at'])) ?>
                                </div>
                            </div>

                            <!-- Delete own post -->
                            <?php if ($post['user_id'] == session()->get('userId')): ?>
                                <form action="<?= base_url('/feed/delete/' . $post['id']) ?>" method="post" class="ms-auto"
                                    onsubmit="return confirm('Delete this post?')">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <p class="mb-0">
                            <?= nl2br(esc($post['content'])) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>