<!doctype html>
<html lang="ru">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAB</title>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= app()->route->getUrl('/hello') ?>">
                <i class="bi bi-mortarboard-fill me-2"></i>LAB
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar"
                    aria-expanded="false"
                    aria-label="Меню">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= app()->route->getUrl('/hello') ?>">
                            <i class="bi bi-house-door me-1"></i>Главная
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= app()->route->getUrl('/department') ?>">
                            <i class="bi bi-building me-1"></i>Кафедры
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= app()->route->getUrl('/equipment') ?>">
                            <i class="bi bi-pc-display me-1"></i>Оборудование
                        </a>
                    </li>

                    <?php if (app()->auth::check() && app()->auth::user()->role == 'ADMIN'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear me-1"></i>Администрирование
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    <a class="dropdown-item" href="<?= app()->route->getUrl('/admin_control/user_control') ?>">
                                        <i class="bi bi-people me-2"></i>Управление пользователями
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= app()->route->getUrl('/admin_control/department_control') ?>">
                                        <i class="bi bi-building-gear me-2"></i>Управление кафедрами
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= app()->route->getUrl('/admin_control/equipment_control') ?>">
                                        <i class="bi bi-tools me-2"></i>Управление оборудованием
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (!app()->auth::check()): ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="<?= app()->route->getUrl('/login') ?>">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Вход
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars(app()->auth::user()->name); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <li>
                                    <span class="dropdown-item-text text-muted">
                                        <small style="color: aliceblue">Вы вошли как</small><br>
                                        <strong style="color: aliceblue"><?= htmlspecialchars(app()->auth::user()->name); ?></strong>
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?= app()->route->getUrl('/logout') ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>Выход
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="py-4">
    <?= $content ?? '' ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>