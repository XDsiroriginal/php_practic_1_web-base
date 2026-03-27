<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Регистрация нового пользователя</h2>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info text-center" role="alert">
                            <?= $message; ?>
                        </div>
                    <?php else: ?>
                        <form method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Имя</label>
                                <input type="text"
                                       class="form-control"
                                       id="name"
                                       name="name"
                                       placeholder="Введите имя"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label for="user_name" class="form-label">Логин</label>
                                <input type="text"
                                       class="form-control"
                                       id="user_name"
                                       name="user_name"
                                       placeholder="Введите логин"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password"
                                       class="form-control"
                                       id="password"
                                       name="password"
                                       placeholder="Введите пароль"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="department_id" class="form-label">Кафедра</label>
                                <select class="form-select"
                                        id="department_id"
                                        name="department_id"
                                        required>
                                    <option value="" disabled selected>Выберите кафедру</option>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?= $department->department_id; ?>">
                                            <?= $department->description; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>