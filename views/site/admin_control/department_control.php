<!doctype html>
<html lang="ru">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление кафедрами</title>
</head>
<body class="bg-light">


<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-primary">
            <i class="bi bi-building me-2"></i>Управление кафедрами
        </h1>
        <a href="<?= app()->route->getUrl('/admin_control/department_control/department_add') ?>"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Добавить кафедру
        </a>
    </div>

    <div class="col-md-6 col-lg-4 mb-3">
        <div class="input-group">
        <span class="input-group-text bg-white">
            <i class="bi bi-search text-muted"></i>
        </span>
            <input id="search" type="text" class="form-control"
                   placeholder="Поиск по названию..." autocomplete="off">
            <button class="btn btn-outline-secondary d-none" id="clearSearch" type="button">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <small class="text-muted" id="searchCount"></small>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <?php if (empty($departments)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    <p class="mb-0">Кафедры не найдены</p>
                    <small>Начните с добавления первой кафедры</small>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 60px;">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Описание</th>
                            <th scope="col" class="text-end" style="width: 120px;">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($departments as $department): ?>
                            <tr>
                                <td class="text-muted">#<?= $department->department_id; ?></td>
                                <td>
                                    <a href="<?= app()->route->getUrl('/admin_control/department_control/department_change?department_id=') . $department->department_id; ?>"
                                       class="text-decoration-none fw-semibold">
                                        <?= $department->name; ?>
                                    </a>
                                </td>
                                <td class="text-muted small">
                                    <?= !empty($department->description) ? htmlspecialchars($department->description) : '—'; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= app()->route->getUrl('/admin_control/department_control/department_change?department_id=') . $department->department_id; ?>"
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
            <?php endif; ?>
        </div>
    </div>
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
</body>
</html>