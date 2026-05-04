<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">

        <!-- ─── Profile Header ───────────────────────────────────────────────── -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center gap-4">

                    <!-- Avatar -->
                    <div class="text-center">
                        <img src="<?= base_url('uploads/' . $profileUser['profile_pic']) ?>"
                            class="rounded-circle shadow" width="100" height="100" style="object-fit:cover;"
                            alt="profile picture">

                        <?php if ($profileUser['id'] == session()->get('userId')): ?>
                            <form action="<?= base_url('/profile/upload') ?>" method="post" enctype="multipart/form-data"
                                class="mt-2">
                                <?= csrf_field() ?>
                                <label class="btn btn-outline-secondary btn-sm" style="cursor:pointer;">
                                    <i class="bi bi-camera me-1"></i>Change Photo
                                    <input type="file" name="profile_pic" accept="image/*" class="d-none"
                                        onchange="this.form.submit()">
                                </label>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div class="flex-grow-1 text-center text-sm-start">
                        <h4 class="fw-bold mb-0">
                            <?= esc($profileUser['first_name'] . ' ' . $profileUser['last_name']) ?>
                        </h4>
                        <p class="text-muted mb-1">@
                            <?= esc($profileUser['username']) ?>
                        </p>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            Born:
                            <?= date('F j, Y', strtotime($profileUser['dob'])) ?>
                            &nbsp;·&nbsp;
                            <i class="bi bi-person me-1"></i>
                            <?= esc($profileUser['sex']) ?>
                        </p>

                        <!-- Stats -->
                        <div class="d-flex gap-4 justify-content-center justify-content-sm-start">
                            <div class="text-center">
                                <div class="fw-bold fs-5">
                                    <?= count($posts) ?>
                                </div>
                                <div class="text-muted small">Posts</div>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold fs-5">
                                    <?= $followerCount ?>
                                </div>
                                <div class="text-muted small">Followers</div>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold fs-5">
                                    <?= $followingCount ?>
                                </div>
                                <div class="text-muted small">Following</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div>
                        <?php if ($profileUser['id'] == session()->get('userId')): ?>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil me-1"></i>Edit Profile
                            </button>
                        <?php elseif ($isFollowing): ?>
                            <form action="<?= base_url('/unfollow/' . $profileUser['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-person-dash me-1"></i>Unfollow
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="<?= base_url('/follow/' . $profileUser['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button class="btn btn-primary btn-sm">
                                    <i class="bi bi-person-plus me-1"></i>Follow
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- ─── Posts ─────────────────────────────────────────────────────────── -->
        <h6 class="text-muted fw-semibold text-uppercase mb-3" style="letter-spacing:.08em;font-size:.75rem;">
            Posts
        </h6>

        <?php if (empty($posts)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-journal-x display-4"></i>
                <p class="mt-3">No posts yet.</p>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                <?= date('M j, Y · g:i A', strtotime($post['created_at'])) ?>
                            </small>
                            <?php if ($profileUser['id'] == session()->get('userId')): ?>
                                <form action="<?= base_url('/feed/delete/' . $post['id']) ?>" method="post"
                                    onsubmit="return confirm('Delete this post?')">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <p class="mb-0">
                            <?= nl2br(esc($post['content'])) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- ─── Edit Profile Modal ────────────────────────────────────────────────── -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('/profile/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                value="<?= esc($profileUser['first_name']) ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Last Name</label>
                            <input type="text" name="last_name" class="form-control"
                                value="<?= esc($profileUser['last_name']) ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>