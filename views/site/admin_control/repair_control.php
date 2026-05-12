<body>
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Управление ремонтами</h1>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" action="" class="search-box">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Поиск по оборудованию, модели, производителю..."
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i> Найти
                    </button>
                    <?php if (!empty($_GET['search'])): ?>
                        <a href="<?= app()->route->getUrl('/admin_control/repair_control') ?>"
                           class="btn btn-outline-danger">
                            <i class="bi bi-x-circle"></i> Сбросить
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php if ($repairs->isEmpty()): ?>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Ремонты не найдены.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Оборудование</th>
                            <th>Пользователь</th>
                            <th>Дата заявки</th>
                            <th>Сообщение о поломке</th>
                            <th>Дата начала</th>
                            <th>Дата окончания</th>
                            <th>Стоимость</th>
                            <th>Статус</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($repairs as $repair): ?>
                            <?php
                            $equipment = $equipments->where('equipment_id', $repair->equipment_id)->first();
                            $userRepair = \Model\User::find($repair->user_id);
                            $status = $statuses->where('status_id', $repair->status_id)->first();

                            $statusClass = 'secondary';
                            if ($repair->status === 'IN_REPAIR') {
                                $statusClass = 'warning';
                            } elseif ($repair->status === 'COMPLETED') {
                                $statusClass = 'success';
                            } elseif ($repair->status === 'CANCELLED') {
                                $statusClass = 'danger';
                            }
                            ?>
                            <tr>
                                <td><?= $repair->repair_id ?></td>
                                <td>
                                    <?php if ($equipment): ?>
                                        <strong><?= htmlspecialchars($equipment->name) ?></strong><br>
                                        <small class="text-muted"><?= htmlspecialchars($equipment->model ?? '') ?></small>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($userRepair): ?>
                                        <?= htmlspecialchars($userRepair->name) ?>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $repair->report_date ? date('d.m.Y H:i', strtotime($repair->report_date)) : '—' ?>
                                </td>
                                <td>
                                    <small><?= htmlspecialchars(mb_substr($repair->break_message ?? '—', 0, 50)) ?>
                                        <?= mb_strlen($repair->break_message ?? '') > 50 ? '...' : '' ?></small>
                                </td>
                                <td>
                                    <?= $repair->repair_start_date ? date('d.m.Y', strtotime($repair->repair_start_date)) : '—' ?>
                                </td>
                                <td>
                                    <?= $repair->repair_end_date ? date('d.m.Y', strtotime($repair->repair_end_date)) : '—' ?>
                                </td>
                                <td>
                                    <?= $repair->cost ? number_format($repair->cost, 0, '.', ' ') . ' ₽' : '—' ?>
                                </td>
                                <td>
                                        <span class="badge bg-<?= $statusClass ?> status-badge">
                                            <?= $repair->status ?? '—' ?>
                                        </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?= app()->route->getUrl('/admin_control/repair_change?repair_id=' . $repair->repair_id) ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Редактировать">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-muted">
                    <small>Найдено: <strong><?= $repairs->count() ?></strong> записей о ремонтах</small>
                    <?php if (!empty($_GET['search'])): ?>
                        <small>(поиск: "<?= htmlspecialchars($_GET['search']) ?>")</small>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>