<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Управление пользователями</h1>
        <a href="<?= app()->route->getUrl('/admin_control/user_control/add_user') ?>"
           class="btn btn-success">
            <i class="bi bi-person-plus"></i> Добавить пользователя
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <?php if (empty($users)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h4 class="mt-3">Пользователи не найдены</h4>
                    <p class="text-muted">Начните с добавления первого пользователя</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Логин</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Роль</th>
                            <th scope="col">Кафедра</th>
                            <th scope="col">Дата регистрации</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="text-muted">#<?= $user->user_id; ?></td>
                                <td>
                                    <a href="<?= app()->route->getUrl('/admin_control/user_control/user_details?user_id=') . $user->user_id; ?>"
                                       class="text-decoration-none">
                                        <?= htmlspecialchars($user->user_name); ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($user->name); ?></td>
                                <td>
                                        <span class="badge bg-<?=
                                        $user->role === 'admin' ? 'danger' :
                                            ($user->role === 'moderator' ? 'warning' : 'info')
                                        ?>">
                                            <?= htmlspecialchars($user->role); ?>
                                        </span>
                                </td>
                                <td>
                                    <?php
                                    $description = $departments
                                        ->where('department_id', $user->department_id)
                                        ->first()
                                        ->description;
                                    if ($description): ?>
                                        <?= htmlspecialchars($description); ?>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted">
                                    <?= date('d.m.Y', strtotime($user->time_create)); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>