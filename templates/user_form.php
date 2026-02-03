<div class="row justify-content-center">
    <div class="col-12 col-md-5 col-lg-4">

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="<?= $action ?>" method="post" id="user-form">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                        type="text"
                        class="form-control"
                        name="name"
                        value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                        required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input
                        type="tel"
                        class="form-control"
                        name="phone"
                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                        placeholder="+7 999 123-45-67"
                        required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                        type="email"
                        class="form-control"
                        name="email"
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                        required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input
                        type="password"
                        class="form-control"
                        name="password"
                        <?= $mode === 'register' ? 'required' : '' ?>
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm password</label>
                <input
                        type="password"
                        class="form-control"
                        name="password_confirm"
                        <?= $mode === 'register' ? 'required' : '' ?>
                >
            </div>

            <?php if ($mode === 'register'): ?>

                <!-- SmartCaptcha -->
                <div
                        class="smart-captcha"
                        data-sitekey="YOUR_SITE_KEY"
                        data-callback="onRegisterCaptchaSuccess">
                </div>

                <input type="hidden" name="smartcaptcha_token" id="smartcaptcha-token">

                <button type="button" class="btn btn-primary w-100">
                    Зарегистрироваться
                </button>

            <?php else: ?>

                <button type="submit" class="btn btn-primary w-100">
                    Сохранить
                </button>

            <?php endif; ?>

        </form>
    </div>
</div>

<?php if ($mode === 'register'): ?>
    <script>
        function onRegisterCaptchaSuccess(token) {
            document.getElementById('smartcaptcha-token').value = token;
        }
    </script>
<?php endif; ?>
