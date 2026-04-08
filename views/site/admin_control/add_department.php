<!doctype html>
<html lang="ru">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= ($department->department_id ?? null) ? 'Редактирование' : 'Создание'; ?> кафедры — LAB</title>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <main class="<?= app()->auth::check() && app()->auth::user()->role == 'ADMIN' ? 'col-md-9 mx-auto col-lg-10' : 'col-12'; ?> content-wrapper">


            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h1 class="h4 mb-0 text-dark">
                    <i class="bi bi-building-gear me-2 text-primary"></i>
                    <?= ($department->department_id ?? null) ? 'Редактирование кафедры' : 'Создание новой кафедры'; ?>
                </h1>
                <a href="<?= app()->route->getUrl('/admin_control/department_control') ?>"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Назад к списку
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-secondary">
                        <i class="bi bi-pencil-square me-2"></i>Основная информация
                    </h5>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Ошибка!</strong> Проверьте правильность заполнения полей:
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $field => $message): ?>
                                    <li><?= htmlspecialchars($message); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" novalidate>
                        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Название кафедры <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-tag text-muted"></i>
                                </span>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?>"
                                       placeholder="Например: Кафедра информационных технологий"
                                       value="<?= htmlspecialchars($department->name ?? ''); ?>"
                                       required
                                       autofocus>
                                <?php if (isset($errors['name'])): ?>
                                    <div class="invalid-feedback"><?= htmlspecialchars($errors['name']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-text">Полное официальное название кафедры</div>
                        </div>

                        <div class="mb-4">
                            <label for="code" class="form-label fw-semibold">
                                Код кафедры <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-hash text-muted"></i>
                                </span>
                                <input type="text"
                                       id="code"
                                       name="code"
                                       class="form-control <?= isset($errors['code']) ? 'is-invalid' : ''; ?>"
                                       placeholder="Например: IT-2024"
                                       value="<?= htmlspecialchars($department->code ?? ''); ?>"
                                       required
                                       pattern="[A-Za-z0-9\-_]+"
                                       maxlength="50">
                                <?php if (isset($errors['code'])): ?>
                                    <div class="invalid-feedback"><?= htmlspecialchars($errors['code']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-text">Уникальный идентификатор (латиница, цифры, дефис)</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Описание
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light align-self-start">
                                    <i class="bi bi-text-paragraph text-muted"></i>
                                </span>
                                <textarea id="description"
                                          name="description"
                                          class="form-control <?= isset($errors['description']) ? 'is-invalid' : ''; ?>"
                                          placeholder="Краткое описание деятельности кафедры..."
                                          rows="4"><?= htmlspecialchars($department->description ?? ''); ?></textarea>
                            </div>
                            <div class="form-text">Информация о направлениях подготовки, преподавателях и т.д.</div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <a href="<?= app()->route->getUrl('/admin_control/department_control') ?>"
                               class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i>Отмена
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i>
                                <?= ($department->department_id ?? null) ? 'Сохранить изменения' : 'Создать кафедру'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (!empty($department->department_id)): ?>
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body">
                        <h6 class="card-subtitle text-muted mb-3">
                            <i class="bi bi-info-circle me-1"></i>Системная информация
                        </h6>
                        <dl class="row mb-0 small">
                            <dt class="col-sm-4 text-muted">ID кафедры</dt>
                            <dd class="col-sm-8">#<?= $department->department_id; ?></dd>

                            <?php if (!empty($department->created_at)): ?>
                                <dt class="col-sm-4 text-muted">Дата создания</dt>
                                <dd class="col-sm-8"><?= date('d.m.Y H:i', strtotime($department->created_at)); ?></dd>
                            <?php endif; ?>

                            <?php if (!empty($department->updated_at)): ?>
                                <dt class="col-sm-4 text-muted">Последнее изменение</dt>
                                <dd class="col-sm-8"><?= date('d.m.Y H:i', strtotime($department->updated_at)); ?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>
            <?php endif; ?>

        </main>
    </div>
</div>

</body>
</html>