<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h2>Создание нового оборудования</h2>

            <a href="<?= app()->route->getUrl('/admin_control/equipment_control') ?>" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Назад к списку
            </a>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <strong>Ошибка!</strong> Проверьте правильность заполнения полей:
                    <ul class="mb-0 mt-2">
                        <?php foreach ($errors as $message): ?>
                            <li><?= htmlspecialchars($message) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>



            <form method="POST" action="<?= app()->route->getUrl('/admin_control/equipment_control/equipment_add') ?>">
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                <div class="card mb-4">
                    <div class="card-header bg-light fw-bold">Основная информация</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Название оборудования *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Модель</label>
                                <input type="text" class="form-control" id="model" name="model">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="manufacturer" class="form-label">Производитель</label>
                                <input type="text" class="form-control" id="manufacturer" name="manufacturer">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="commission_date" class="form-label">Дата ввода в эксплуатацию</label>
                                <input type="date" class="form-control" id="commission_date" name="commission_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cost" class="form-label">Стоимость (₽)</label>
                                <input type="number" class="form-control" id="cost" name="cost" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light fw-bold">Привязка и Ответственные</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="department_id" class="form-label">Кафедра</label>
                                <select class="form-select" id="department_id" name="department_id">
                                    <option value="">Не выбрана</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= $dept->department_id ?>">
                                            <?= htmlspecialchars($dept->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status_id" class="form-label">Статус</label>
                                <select class="form-select" id="status_id" name="status_id">
                                    <option value="">Не указан</option>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= $status->status_id ?>">
                                            <?= htmlspecialchars($status->name ?? "Статус #{$status->status_id}") ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Ответственный пользователь</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="">Не назначен</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user->user_id ?>">
                                        <?= htmlspecialchars($user->login ?? $user->email ?? "{$user->name}") ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mb-4">
                    <a href="<?= app()->route->getUrl('/admin_control/equipment_control') ?>" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Создать оборудование</button>
                </div>
            </form>
        </div>
    </div>
</div>