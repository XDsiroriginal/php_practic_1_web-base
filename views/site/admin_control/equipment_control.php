<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-cpu"></i>
            Управление оборудованием
        </h2>
        <a href="<?= app()->route->getUrl('/admin_control/equipment_control/equipment_add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Добавить оборудование
        </a>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="GET" action="">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Поиск по названию..."
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                    >
                    <?php if (!empty($_GET['search'])): ?>
                        <a href="<?= app()->route->getUrl('/admin_control/equipment_control') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <?php if (empty($equipments)): ?>
        <div class="alert alert-info" role="alert">
            Оборудование не найдено. Начните с добавления первой единицы оборудования.
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%;">ID</th>
                        <th scope="col" style="width: 15%;">Название</th>
                        <th scope="col" style="width: 15%;">Модель</th>
                        <th scope="col" style="width: 15%;">Производитель</th>
                        <th scope="col" style="width: 10%;">Дата ввода</th>
                        <th scope="col" style="width: 10%;">Стоимость</th>
                        <th scope="col" style="width: 20%;">Кафедра</th>
                        <th scope="col" style="width: 10%; text-align: center;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($equipments as $equipment): ?>
                        <?php
                        $status = $statuses->where('status_id', $equipment->status_id)->first();
                        $department = $departments->where('department_id', $equipment->department_id)->first();
                        ?>
                        <tr>
                            <td># <?= $equipment->equipment_id; ?></td>
                            <td>
                                <a href="<?= app()->route->getUrl('/admin_control/equipment_control/equipment_change?equipment_id=') . $equipment->equipment_id; ?>" class="text-decoration-none fw-bold text-primary">
                                    <?= htmlspecialchars($equipment->name); ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($equipment->model ?? '—'); ?></td>
                            <td><?= htmlspecialchars($equipment->manufacturer ?? '—'); ?></td>
                            <td><?= !empty($equipment->commission_date) ? date('d.m.Y', strtotime($equipment->commission_date)) : '—'; ?></td>
                            <td><?= !empty($equipment->cost) ? number_format($equipment->cost, 0, '.', ' ') . ' ₽' : '—'; ?></td>
                            <td>
                                <?php if (!empty($equipment->department_id) && $department): ?>
                                    <?= htmlspecialchars($department->name); ?>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= app()->route->getUrl('/admin_control/equipment_control/equipment_change?equipment_id=') . $equipment->equipment_id; ?>"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($_GET['search'])): ?>
            <div class="mt-3 text-muted">
                Найдено: <?= count($equipments) ?> ед. оборудования (поиск: "<?= htmlspecialchars($_GET['search']) ?>")
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const clearBtn = document.getElementById('clearSearch');
        const rows = document.querySelectorAll('tbody tr');
        const searchCount = document.getElementById('searchCount');

        let timeout = null;
        searchInput?.addEventListener('input', function(e) {
            clearTimeout(timeout);
            timeout = setTimeout(() => filterRows(e.target.value.toLowerCase()), 300);

            clearBtn?.classList.toggle('d-none', !e.target.value);
        });

        clearBtn?.addEventListener('click', function() {
            searchInput.value = '';
            filterRows('');
            searchInput.focus();
        });

        function filterRows(term) {
            let visibleCount = 0;

            rows.forEach(row => {
                const nameCell = row.querySelector('td:nth-child(2)');
                const name = nameCell?.textContent.toLowerCase() || '';
                const desc = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';

                if (!term || name.includes(term) || desc.includes(term)) {
                    row.style.display = '';
                    visibleCount++;

                    if (term && nameCell) {
                        highlightText(nameCell, term);
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            if (term) {
                searchCount.textContent = `Найдено: ${visibleCount} из ${rows.length}`;
            } else {
                searchCount.textContent = '';
            }

            showEmptyMessage(visibleCount === 0 && term);
        }

        function highlightText(element, term) {
            const originalText = element.dataset.original || element.innerHTML;
            element.dataset.original = originalText;

            if (!term) {
                element.innerHTML = originalText;
                return;
            }

            const escaped = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const regex = new RegExp(`(${escaped})`, 'gi');
            element.innerHTML = originalText.replace(regex, '<mark class="bg-warning bg-opacity-25">$1</mark>');
        }

        function showEmptyMessage(show) {
            let emptyMsg = document.getElementById('emptySearchMsg');

            if (show && !emptyMsg) {
                emptyMsg = document.createElement('tr');
                emptyMsg.id = 'emptySearchMsg';
                emptyMsg.innerHTML = `<td colspan="4" class="text-center text-muted py-4">
                <i class="bi bi-search d-block fs-4 mb-2"></i>Ничего не найдено по запросу "${searchInput.value}"
            </td>`;
                document.querySelector('tbody').appendChild(emptyMsg);
            } else if (!show && emptyMsg) {
                emptyMsg.remove();
            }
        }
    });
</script>