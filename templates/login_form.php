<div class="row justify-content-center">
    <div class="col-12 col-md-5 col-lg-4">

        <form action="<?= $action ?>" method="post" id="login-form">

            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="alert alert-danger">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Email или телефон</label>
                <input
                        type="text"
                        name="login"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($_SESSION['old']['login'] ?? '') ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                >
            </div>

            <!-- SmartCaptcha -->
            <div
                    class="smart-captcha"
                    data-sitekey="YOUR_SITE_KEY"
                    data-callback="onSmartCaptchaSuccess">
            </div>

            <input
                    type="hidden"
                    name="smartcaptcha_token"
                    id="smartcaptcha-token"
            >

            <button type="submit" class="btn btn-primary w-100">
                Войти
            </button>

        </form>
    </div>
</div>

<script>
    let captchaPassed = false;

    function onSmartCaptchaSuccess(token) {
        document.getElementById('smartcaptcha-token').value = token;
        captchaPassed = true;
    }

    document.getElementById('login-form').addEventListener('submit', function (e) {
        if (!captchaPassed) {
            e.preventDefault();
            alert('Подтвердите, что вы не робот');
        }
    });
</script>
