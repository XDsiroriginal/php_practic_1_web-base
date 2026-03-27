<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h1 class="card-title mb-3"><?= htmlspecialchars($user->name); ?></h1>
                        <div class="badge bg-secondary fs-6">
                            ID: <?= $user->user_id ?? 'N/A'; ?>
                        </div>
                    </div>

                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-person-circle me-2"></i>
                                <strong>Логин:</strong>
                            </div>
                            <span class="text-muted"><?= htmlspecialchars($user->user_name); ?></span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-shield-check me-2"></i>
                                <strong>Роль:</strong>
                            </div>
                            <span class="badge bg-info"><?= htmlspecialchars($user->role); ?></span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-building me-2"></i>
                                <strong>Кафедра:</strong>
                            </div>
                            <span class="text-muted"><?= htmlspecialchars($departments->description); ?></span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-calendar-plus me-2"></i>
                                <strong>Дата регистрации:</strong>
                            </div>
                            <span class="text-muted">
                                <?= date('d.m.Y H:i', strtotime($user->time_create)); ?>
                            </span>
                        </div>
                    </div>

<!--                    <div class="mt-4 pt-3 border-top text-center">-->
<!--                        <a href="/users" class="btn btn-outline-secondary me-2">-->
<!--                            <i class="bi bi-arrow-left"></i> Назад к списку-->
<!--                        </a>-->
<!--                        <a href="/profile/edit/--><?php //= $user->user_id; ?><!--" class="btn btn-primary">-->
<!--                            <i class="bi bi-pencil-square"></i> Редактировать-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>