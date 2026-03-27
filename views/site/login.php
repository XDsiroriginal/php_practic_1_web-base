<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Авторизация</h2>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?= $message; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!app()->auth::check()): ?>
                        <form method="post">
                            <div class="mb-3">
                                <label for="user_name" class="form-label">Логин</label>
                                <input type="text"
                                       class="form-control"
                                       id="user_name"
                                       name="user_name"
                                       placeholder="Введите логин"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password"
                                       class="form-control"
                                       id="password"
                                       name="password"
                                       placeholder="Введите пароль"
                                       required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Войти
                                </button>
                            </div>
                        </form>

                    <?php else: ?>
                        <div class="alert alert-success text-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Вы вошли как <strong><?= app()->auth->user()->name; ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>