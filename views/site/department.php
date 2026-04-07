<!doctype html>
<html lang="ru">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Кафедра</title>
</head>
<body>
<?php if ($user->role == 'USER'):?>
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-semibold mb-0">
                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                    <?= htmlspecialchars($departments->description) ?>
                </h1>
                <p class="text-muted mt-2">Информация о кафедре и её ресурсах</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people-fill fs-4 me-2 text-primary"></i>
                            <h5 class="card-title mb-0 fw-semibold">Пользователи кафедры</h5>
                            <span class="badge bg-primary rounded-pill ms-2">
                            <?= count($userOnThisDepartment) ?>
                        </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($userOnThisDepartment)): ?>
                            <div class="text-center py-4">
                                <i class="bi bi-person-x display-6 text-muted"></i>
                                <p class="text-muted mt-2 mb-0">На кафедре пока нет пользователей</p>
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($userOnThisDepartment as $users): ?>
                                    <div class="list-group-item px-0 d-flex align-items-center">
                                        <i class="bi bi-person-circle fs-5 me-3 text-secondary"></i>
                                        <div>
                                            <span class="fw-medium"><?= htmlspecialchars($users->name) ?></span>
                                            <?php if (!empty($users->role)): ?>
                                                <span class="badge bg-secondary ms-2"><?= htmlspecialchars($users->role) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-pc-display fs-4 me-2 text-success"></i>
                            <h5 class="card-title mb-0 fw-semibold">Оборудование кафедры</h5>
                            <span class="badge bg-success rounded-pill ms-2">
                            <?= count($equipment) ?>
                        </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($equipment)): ?>
                            <div class="text-center py-4">
                                <i class="bi bi-tools display-6 text-muted"></i>
                                <p class="text-muted mt-2 mb-0">Оборудование не добавлено</p>
                            </div>
                        <?php else: ?>
                            <div class="row g-2">
                                <?php foreach ($equipment as $item): ?>
                                    <div class="col-sm-6">
                                        <div class="border rounded p-2 d-flex align-items-center">
                                            <i class="bi bi-device-hdd fs-5 me-2 text-info"></i>
                                            <span><?= htmlspecialchars($item->name) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else:?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-semibold mb-0">
                    <i class="bi bi-building-fill-gear text-primary me-2"></i>
                    Все кафедры
                </h1>
                <p class="text-muted mt-2">Общая информация по кафедрам, пользователям и оборудованию</p>
            </div>
            <span class="badge bg-primary rounded-pill fs-6">
            <?= count($allDepartments) ?> кафедр
        </span>
        </div>

        <?php if (empty($allDepartments)): ?>
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inboxes display-4 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Кафедры пока не добавлены</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($allDepartments as $department): ?>
                    <?php
                    $usersFromDepartment = $allUser->where('department_id', $department->department_id);
                    $equipmentFromDepartment = $allEquipment->where('department_id', $department->department_id);
                    ?>
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                    <div class="mb-2 mb-md-0">
                                        <h4 class="mb-1 fw-semibold">
                                            <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                                            <?= htmlspecialchars($department->description) ?>
                                        </h4>
                                        <small class="text-muted">
                                            ID кафедры: <?= htmlspecialchars($department->department_id) ?>
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge bg-primary rounded-pill">
                                        <i class="bi bi-people-fill me-1"></i>
                                        <?= count($usersFromDepartment) ?> пользователей
                                    </span>
                                        <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-pc-display me-1"></i>
                                        <?= count($equipmentFromDepartment) ?> оборудования
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="card h-100 border">
                                            <div class="card-header bg-light">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-people-fill fs-5 me-2 text-primary"></i>
                                                    <h5 class="mb-0">Пользователи кафедры</h5>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <?php if (count($usersFromDepartment) == 0): ?>
                                                    <div class="text-center py-4">
                                                        <i class="bi bi-person-x display-6 text-muted"></i>
                                                        <p class="text-muted mt-2 mb-0">Пользователей нет</p>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="list-group list-group-flush">
                                                        <?php foreach ($usersFromDepartment as $departmentUser): ?>
                                                            <div class="list-group-item px-0 d-flex align-items-center">
                                                                <i class="bi bi-person-circle fs-5 me-3 text-secondary"></i>
                                                                <div>
                                                                    <span class="fw-medium"><?= htmlspecialchars($departmentUser->name) ?></span>
                                                                    <?php if (!empty($departmentUser->role)): ?>
                                                                        <span class="badge bg-secondary ms-2">
                                                                        <?= htmlspecialchars($departmentUser->role) ?>
                                                                    </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card h-100 border">
                                            <div class="card-header bg-light">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-pc-display fs-5 me-2 text-success"></i>
                                                    <h5 class="mb-0">Оборудование кафедры</h5>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <?php if (count($equipmentFromDepartment) == 0): ?>
                                                    <div class="text-center py-4">
                                                        <i class="bi bi-tools display-6 text-muted"></i>
                                                        <p class="text-muted mt-2 mb-0">Оборудование не добавлено</p>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="row g-2">
                                                        <?php foreach ($equipmentFromDepartment as $equipment): ?>
                                                            <div class="col-sm-6">
                                                                <div class="border rounded p-2 d-flex align-items-center h-100">
                                                                    <i class="bi bi-device-hdd fs-5 me-2 text-info"></i>
                                                                    <span><?= htmlspecialchars($equipment->name) ?></span>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<?php endif; ?>
</body>