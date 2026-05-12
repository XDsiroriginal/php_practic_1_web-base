
<div class="container">

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Информация об оборудовании</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="fw-bold">Название</label>
                    <p class="mb-0"><?= htmlspecialchars($equipment->name ?? '') ?></p>
                </div>
                <div class="col-md-4">
                    <label class="fw-bold">Модель</label>
                    <p class="mb-0"><?= htmlspecialchars($equipment->model ?? '') ?></p>
                </div>
                <div class="col-md-4">
                    <label class="fw-bold">Производитель</label>
                    <p class="mb-0"><?= htmlspecialchars($equipment->manufacturer ?? '') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Информация о поломке</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="fw-bold">Дата сообщения</label>
                    <p class="mb-0"><?= !empty($repair->report_date) ? date('d.m.Y', strtotime($repair->report_date)) : 'Не указана' ?></p>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Сообщивший</label>
                    <p class="mb-0">
                        <?php
                        $reporter = $users->firstWhere('user_id', $repair->user_id);
                        echo htmlspecialchars($reporter->full_name ?? $reporter->name ?? 'Не указан');
                        ?>
                    </p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <label class="fw-bold">Описание поломки</label>
                    <p class="mb-0"><?= htmlspecialchars($repair->break_message ?? 'Не указано') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Основная информация</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="repair_start_date" class="form-label">Дата начала ремонта</label>
                        <input type="date" class="form-control" id="repair_start_date" name="repair_start_date"
                               value="<?= htmlspecialchars($repair->repair_start_date ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="repair_end_date" class="form-label">Дата окончания ремонта</label>
                        <input type="date" class="form-control" id="repair_end_date" name="repair_end_date"
                               value="<?= htmlspecialchars($repair->repair_end_date ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Статус ремонта *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Выберите статус</option>
                                    <option value="IN_REPAIR"
                                        <p>IN_REPAIR</p>
                                    </option>
                                    <option value="COMPLETED"
                                        <p>COMPLETED</p>
                                    </option>
                                    <option value="CANCELLED"
                                        <p>CANCELLED</p>
                                    </option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label for="cost" class="form-label">Стоимость ремонта</label>
                        <input type="number" step="0.01" class="form-control" id="cost" name="cost"
                               value="<?= htmlspecialchars($repair->cost ?? '') ?>"
                               placeholder="Стоимость в рублях">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-12">
                        <label for="work_performed" class="form-label">Выполненные работы</label>
                        <textarea class="form-control" id="work_performed" name="work_performed"
                                  rows="4" placeholder="Описание выполненных работ..."><?= htmlspecialchars($repair->work_performed ?? '') ?></textarea>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <a href="<?= app()->route->getUrl('/admin_control/repair_control') ?>" class="btn btn-outline-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($repair->repair_id)): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Системная информация</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="fw-bold">ID ремонта</label>
                        <p class="mb-0">#<?= $repair->repair_id ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Дата создания</label>
                        <p class="mb-0"><?= date('d.m.Y H:i', strtotime($repair->created_at ?? 'now')); ?></p>
                    </div>
                    <?php if (!empty($repair->updated_at)): ?>
                        <div class="col-md-4">
                            <label class="fw-bold">Последнее изменение</label>
                            <p class="mb-0"><?= date('d.m.Y H:i', strtotime($repair->updated_at)); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>