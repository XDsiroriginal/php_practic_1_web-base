<?php
$title = $equipment->equipment_id ? 'Редактирование' : 'Создание';
$pageTitle = $equipment->equipment_id ? 'Редактирование оборудования' : 'Создание нового оборудования';
$submitText = $equipment->equipment_id ? 'Сохранить изменения' : 'Создать оборудование';
?>

<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= $title ?> оборудования</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= app()->route->getUrl('/admin_control/equipment_control') ?>" class="btn btn-sm btn-outline-secondary">
                Назад к списку
            </a>
        </div>
    </div>

    <h2 class="mb-4"><?= $pageTitle ?></h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Основная информация</h5>
        </div>
        <div class="card-body">
            <form method="POST" >
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Название оборудования *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($equipment->name ?? '') ?>" required placeholder="Полное официальное название оборудования">
                    </div>
                    <div class="col-md-3">
                        <label for="model" class="form-label">Модель *</label>
                        <input type="text" class="form-control" id="model" name="model" value="<?= htmlspecialchars($equipment->model ?? '') ?>" required placeholder="Модель оборудования">
                    </div>
                    <div class="col-md-5">
                        <label for="manufacturer" class="form-label">Производитель *</label>
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="<?= htmlspecialchars($equipment->manufacturer ?? '') ?>" required placeholder="Наименование производителя">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-3">
                        <label for="commission_date" class="form-label">Дата ввода в эксплуатацию</label>
                        <input type="date" class="form-control" id="commission_date" name="commission_date" value="<?= htmlspecialchars($equipment->commission_date ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="cost" class="form-label">Стоимость</label>
                        <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="<?= htmlspecialchars($equipment->cost ?? '') ?>" placeholder="Стоимость в рублях">
                    </div>
                    <div class="col-md-3">
                        <label for="status_id" class="form-label">Статус *</label>
                        <select class="form-select" id="status_id" name="status_id" required>
                            <option value="">Выберите статус</option>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= $status->status_id ?>" <?= ($equipment->status_id ?? '') == $status->status_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($status->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="user_id" class="form-label">Ответственный</label>
                        <select class="form-select" id="user_id" name="user_id">
                            <option value="">Не назначен</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user->user_id ?>" <?= ($equipment->user_id ?? '') == $user->user_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user->full_name ?? $user->name ?? 'Пользователь #' . $user->user_id) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="department_id" class="form-label">Кафедра</label>
                        <select class="form-select" id="department_id" name="department_id">
                            <option value="">Не закреплена</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept->department_id ?>" <?= ($equipment->department_id ?? '') == $dept->department_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <a href="<?= app()->route->getUrl('/admin_control/equipment_control') ?>" class="btn btn-outline-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary"><?= $submitText ?></button>
                </div>
            </form>
        </div>
    </div>

<?php if (!empty($equipment->equipment_id)): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Системная информация</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="fw-bold">ID оборудования</label>
                    <p class="mb-0">#<?= $equipment->equipment_id ?></p>
                </div>
                <div class="col-md-4">
                    <label class="fw-bold">Дата создания</label>
                    <p class="mb-0"><?= date('d.m.Y H:i', strtotime($equipment->created_at ?? 'now')); ?></p>
                </div>
                <?php if (!empty($equipment->updated_at)): ?>
                    <div class="col-md-4">
                        <label class="fw-bold">Последнее изменение</label>
                        <p class="mb-0"><?= date('d.m.Y H:i', strtotime($equipment->updated_at)); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>
