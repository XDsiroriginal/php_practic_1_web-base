<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2>Журнал ремонтов</h2>

            <?php if ($users->role == 'USER'): ?>
                <a href="/repair/add_repair" class="btn btn-primary">
                    <i class="bi bi-exclamation-triangle-fill"></i> Заявить о поломке
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($repairs)): ?>
        <div class="alert alert-info">
            Записи о ремонтах не найдены.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col"># ID</th>
                    <th scope="col">Оборудование</th>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Дата заявки</th>
                    <th scope="col">Описание поломки</th>
                    <th scope="col">Выполненные работы</th>
                    <th scope="col">Стоимость</th>
                    <th scope="col">Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($repairs as $repair): ?>
                    <?php
                    $equipment = collect($equipments)->firstWhere('equipment_id', $repair->equipment_id);
                    $equipmentName = $equipment ? $equipment->name : 'Неизвестно';

                    switch ($repair->status) {
                        case 'IN_REPAIR':
                            $statusText = 'В ремонте';
                            $statusClass = 'bg-warning text-dark';
                            break;
                        case 'COMPLETED':
                            $statusText = 'Завершен';
                            $statusClass = 'bg-success';
                            break;
                        case 'CANCELLED':
                            $statusText = 'Отменен';
                            $statusClass = 'bg-danger';
                            break;
                        default:
                            $statusText = $repair->status;
                            $statusClass = 'bg-secondary';
                            break;
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($repair->repair_id) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($equipmentName) ?></strong><br>
                            <small class="text-muted">ID: <?= htmlspecialchars($repair->equipment_id) ?></small>
                        </td>
                        <td>
                            <?= htmlspecialchars($users->name ?? 'N/A') ?><br>
                            <small class="text-muted">ID: <?= htmlspecialchars($repair->user_id) ?></small>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($repair->report_date)) ?></td>
                        <td style="max-width: 200px;">
                            <?= nl2br(htmlspecialchars($repair->break_message ?? 'Нет описания')) ?>
                        </td>
                        <td style="max-width: 200px;">
                            <?= nl2br(htmlspecialchars($repair->work_performed ?? 'Не указано')) ?>
                        </td>
                        <td>
                            <?= $repair->cost ? number_format($repair->cost, 2, '.', ' ') . ' руб.' : '-' ?>
                        </td>
                        <td>
                                <span class="badge <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>