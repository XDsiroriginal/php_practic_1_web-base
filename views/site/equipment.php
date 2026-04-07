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
<?php if ($user->role == 'USER'): ?>
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-semibold mb-0">
                    <i class="bi bi-pc-display-horizontal text-primary me-2"></i>
                    Оборудование <?= htmlspecialchars($user->name) ?>
                </h1>
                <p class="text-muted mt-2 mb-0">Список оборудования, закреплённого за пользователем</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-hdd-stack-fill fs-4 me-2 text-success"></i>
                    <h5 class="card-title mb-0 fw-semibold">Список оборудования</h5>
                    <span class="badge bg-success rounded-pill ms-2">
                    <?= count($equipments) ?>
                </span>
                </div>
            </div>

            <div class="card-body">
                <?php if (empty($equipments)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-tools display-6 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">У пользователя нет закреплённого оборудования</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($equipments as $equipment): ?>
                            <?php
                            $statuses = $status->where('status_id', $equipment->status_id)->first();

                            switch ($statuses->name ?? '') {
                                case 'BROKEN':
                                    $statusText = 'Сломан';
                                    $statusClass = 'bg-danger';
                                    break;
                                case 'IN REPAIR':
                                    $statusText = 'В ремонте';
                                    $statusClass = 'bg-warning text-dark';
                                    break;
                                case 'IN WORK':
                                    $statusText = 'В работе';
                                    $statusClass = 'bg-success';
                                    break;
                                case 'WRITTEN OFF':
                                    $statusText = 'Списано';
                                    $statusClass = 'bg-secondary';
                                    break;
                                default:
                                    $statusText = 'Без статуса';
                                    $statusClass = 'bg-light text-dark';
                                    break;
                            }
                            ?>

                            <div class="col-md-6 col-xl-4">
                                <div class="card border h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="card-title mb-0 fw-semibold">
                                                <i class="bi bi-cpu-fill text-primary me-2"></i>
                                                <?= htmlspecialchars($equipment->name) ?>
                                            </h5>
                                            <span class="badge <?= $statusClass ?>">
                                            <?= $statusText ?>
                                        </span>
                                        </div>

                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <span class="text-muted">Модель:</span>
                                                <span class="fw-medium"><?= htmlspecialchars($equipment->model) ?></span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-muted">Производитель:</span>
                                                <span class="fw-medium"><?= htmlspecialchars($equipment->manufacturer) ?></span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-muted">Дата ввода в эксплуатацию:</span>
                                                <span class="fw-medium"><?= htmlspecialchars($equipment->commission_date) ?></span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-muted">Стоимость:</span>
                                                <span class="fw-medium"><?= htmlspecialchars($equipment->cost) ?></span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-muted">Создано:</span>
                                                <span class="fw-medium"><?= htmlspecialchars($equipment->created_at) ?></span>
                                            </li>
                                            <li>
                                                <span class="text-muted">Обновлено:</span>
                                                <span class="fw-medium"><?= htmlspecialchars($equipment->updated_at) ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php else: ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-semibold mb-0">
                    <i class="bi bi-hdd-network-fill text-primary me-2"></i>
                    Всё оборудование
                </h1>
                <p class="text-muted mt-2 mb-0">Просмотр оборудования по всем кафедрам и пользователям</p>
            </div>
            <span class="badge bg-primary rounded-pill fs-6">
            <?= count($allEquipment) ?> ед.
        </span>
        </div>

        <?php if (empty($allDepartments)): ?>
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inboxes display-4 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Кафедры не найдены</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($allDepartments as $department): ?>
                    <?php
                    $departmentUsers = $allUser->where('department_id', $department->department_id);
                    $departmentEquipment = $allEquipment->where('department_id', $department->department_id);
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
                                        <?= count($departmentUsers) ?> пользователей
                                    </span>
                                        <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-pc-display-horizontal me-1"></i>
                                        <?= count($departmentEquipment) ?> оборудования
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <?php if (count($departmentEquipment) == 0): ?>
                                    <div class="text-center py-4">
                                        <i class="bi bi-tools display-6 text-muted"></i>
                                        <p class="text-muted mt-2 mb-0">На этой кафедре оборудование не добавлено</p>
                                    </div>
                                <?php else: ?>
                                    <div class="row g-3">
                                        <?php foreach ($departmentEquipment as $equipment): ?>
                                            <?php
                                            $statuses = $status->where('status_id', $equipment->status_id)->first();
                                            $equipmentUser = $allUser->where('user_id', $equipment->user_id)->first();

                                            switch ($statuses->name ?? '') {
                                                case 'BROKEN':
                                                    $statusText = 'Сломан';
                                                    $statusClass = 'bg-danger';
                                                    break;
                                                case 'IN REPAIR':
                                                    $statusText = 'В ремонте';
                                                    $statusClass = 'bg-warning text-dark';
                                                    break;
                                                case 'IN WORK':
                                                    $statusText = 'В работе';
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'WRITTEN OFF':
                                                    $statusText = 'Списано';
                                                    $statusClass = 'bg-secondary';
                                                    break;
                                                default:
                                                    $statusText = 'Без статуса';
                                                    $statusClass = 'bg-light text-dark';
                                                    break;
                                            }
                                            ?>

                                            <div class="col-md-6 col-xl-4">
                                                <div class="card border h-100 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                                            <h5 class="card-title mb-0 fw-semibold">
                                                                <i class="bi bi-cpu-fill text-primary me-2"></i>
                                                                <?= htmlspecialchars($equipment->name) ?>
                                                            </h5>
                                                            <span class="badge <?= $statusClass ?>">
                                                            <?= $statusText ?>
                                                        </span>
                                                        </div>

                                                        <ul class="list-unstyled mb-0">
                                                            <li class="mb-2">
                                                                <span class="text-muted">Пользователь:</span>
                                                                <span class="fw-medium">
                                                                <?= htmlspecialchars($equipmentUser->name ?? 'Не назначен') ?>
                                                            </span>
                                                            </li>
                                                            <li class="mb-2">
                                                                <span class="text-muted">Модель:</span>
                                                                <span class="fw-medium"><?= htmlspecialchars($equipment->model) ?></span>
                                                            </li>
                                                            <li class="mb-2">
                                                                <span class="text-muted">Производитель:</span>
                                                                <span class="fw-medium"><?= htmlspecialchars($equipment->manufacturer) ?></span>
                                                            </li>
                                                            <li class="mb-2">
                                                                <span class="text-muted">Дата ввода:</span>
                                                                <span class="fw-medium"><?= htmlspecialchars($equipment->commission_date) ?></span>
                                                            </li>
                                                            <li class="mb-2">
                                                                <span class="text-muted">Стоимость:</span>
                                                                <span class="fw-medium"><?= htmlspecialchars($equipment->cost) ?></span>
                                                            </li>
                                                            <li class="mb-2">
                                                                <span class="text-muted">Создано:</span>
                                                                <span class="fw-medium"><?= htmlspecialchars($equipment->created_at) ?></span>
                                                            </li>
                                                            <li>
                                                                <span class="text-muted">Обновлено:</span>
                                                                <span class="fw-medium"><?= htmlspecialchars($equipment->updated_at) ?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<?php endif; ?>
</body>