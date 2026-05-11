<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Создание заявки на ремонт</h4>
                    <a href="<?= app()->route->getUrl('/repair') ?>" class="btn btn-outline-secondary btn-sm">
                        ← Назад к списку
                    </a>
                </div>

                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Ошибка!</strong> Проверьте правильность заполнения полей:
                            <?php if (is_array($error)): ?>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($error as $msg): ?>
                                        <li><?= htmlspecialchars($msg) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <?= htmlspecialchars($error) ?>
                            <?php endif; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                        <div class="mb-4">
                            <label for="equipment" class="form-label required">Оборудование</label>
                            <select class="form-select form-select-lg" id="equipment" name="equipment" required>
                                <option value="" disabled selected>Выберите оборудование из вашего списка</option>
                                <?php if (!empty($equipments)): ?>
                                    <?php foreach ($equipments as $eq): ?>
                                        <option value="<?= $eq->equipment_id ?>">
                                            <?= htmlspecialchars($eq->name ?? $eq->model ?? "Оборудование #{$eq->equipment_id}") ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>Нет доступного оборудования</option>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Отображается только оборудование, закрепленное за вами.</div>
                        </div>

                        <div class="mb-4">
                            <label for="break_message" class="form-label required">Описание поломки</label>
                            <textarea class="form-control" id="break_message" name="break_message" rows="5"
                                      required placeholder="Подробно опишите проблему, симптомы неисправности и т.д."></textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="<?= app()->route->getUrl('/repair') ?>" class="btn btn-outline-secondary px-4">
                                Отмена
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                Создать заявку
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>