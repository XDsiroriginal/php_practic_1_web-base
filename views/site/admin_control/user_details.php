<!doctype html>
<html lang="ru">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAB</title>
</head>
<body>

<main class="py-4">
    <?php
    $title = $user->user_id ? 'Редактирование' : 'Создание';
    $pageTitle = $user->user_id ? 'Редактирование пользователя #' . ($user->user_id ?? 'N/A') : 'Создание нового пользователя';
    $submitText = $user->user_id ? 'Сохранить изменения' : 'Создать пользователя';
    ?>
    <div class="container">
        <?php if (!empty($errors) && is_array($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <h4 class="alert-heading">Исправьте ошибки в форме</h4>
                <ul class="mb-0">
                    <?php foreach ($errors as $fieldErrors): ?>
                        <?php foreach ((array)$fieldErrors as $msg): ?>
                            <li><?= htmlspecialchars($msg) ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $title ?> пользователя</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="<?= app()->route->getUrl('/admin_control/user_control') ?>" class="btn btn-sm btn-outline-secondary">Назад к списку</a>
            </div>
        </div>
        <h2 class="mb-4"><?= $pageTitle ?></h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Исправьте ошибки:</strong>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Основная информация</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Имя *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user->name ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="login" class="form-label">Логин *</label>
                            <input type="text" class="form-control" id="login" name="user_name" value="<?= htmlspecialchars($user->user_name ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="password" class="form-label">Пароль (оставьте пустым, если не меняете)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label for="department_id" class="form-label">Кафедра</label>
                            <select class="form-select" id="department_id" name="department_id">
                                <option value="">Выберите кафедру</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept->department_id ?>" <?= ($user->department_id ?? 0) == $dept->department_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($dept->description ?? $dept->name ?? 'ID: ' . $dept->department_id) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="<?= app()->route->getUrl('/admin_control/user_control') ?>" class="btn btn-outline-secondary">Отмена</a>
                        <button type="submit" class="btn btn-primary"><?= $submitText ?></button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (!empty($user->user_id)): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Системная информация</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="fw-bold">ID пользователя</label>
                            <p class="mb-0">#<?= $user->user_id ?? 'N/A' ?></p>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold">Кафедра (ID)</label>
                            <p class="mb-0">#<?= $user->department_id ?? 'N/A' ?></p>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold">Дата регистрации</label>
                            <p class="mb-0"><?= date('d.m.Y H:i', strtotime($user->time_create ?? 'now')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>