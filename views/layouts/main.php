<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAB</title>
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/department') ?>">Кафедры</a>
        <a href="<?= app()->route->getUrl('/equipment') ?>">Оборудование</a>
        <?php
        if (!app()->auth::check()):
            ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>


        <?php
        else:
            ?>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
            <?php
            if(app()->auth::user()->role == 'ADMIN'): ?>
                <a href="<?= app()->route->getUrl('/admin_control/user_control') ?>">управление пользователями</a>
            <?php endif; ?>
        <?php
        endif;
        ?>
    </nav>
</header>
<main>
    <?= $content ?? '' ?>
</main>

</body>
</html>
