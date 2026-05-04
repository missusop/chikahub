<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <i class="bi bi-person-plus display-4 text-success"></i>
                    <h3 class="fw-bold mt-2">Create Account</h3>
                    <p class="text-muted">Join SocialApp today</p>
                </div>

                <form action="<?= base_url('/register') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Row: First Name + Last Name -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Juan"
                                value="<?= old('first_name') ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Dela Cruz"
                                value="<?= old('last_name') ?>" required>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="your_username"
                                value="<?= old('username') ?>" required>
                        </div>
                    </div>

                    <!-- Row: Date of Birth + Sex -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?= old('dob') ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Sex</label>
                            <select name="sex" class="form-select" required>
                                <option value="" disabled <?= old('sex') ? '' : 'selected' ?>>Select…</option>
                                <option value="Male" <?= old('sex') === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('sex') === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('sex') === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="you@example.com"
                                value="<?= old('email') ?>" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Min. 6 characters"
                                required>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="Repeat password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                        <i class="bi bi-person-check me-2"></i>Create Account
                    </button>
                </form>

                <hr class="my-4">
                <p class="text-center text-muted mb-0">
                    Already have an account?
                    <a href="<?= base_url('/login') ?>" class="text-primary fw-semibold">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>