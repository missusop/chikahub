<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="text-center mb-4">
                    <i class="bi bi-stars display-4 text-primary"></i>
                    <h3 class="fw-bold mt-2">Welcome Back</h3>
                    <p class="text-muted">Sign in to SocialApp</p>
                </div>

                <!-- Login Form -->
                <form action="<?= base_url('/login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="you@example.com"
                                value="<?= old('email') ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>

                <hr class="my-4">
                <p class="text-center text-muted mb-0">
                    Don't have an account?
                    <a href="<?= base_url('/register') ?>" class="text-primary fw-semibold">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>