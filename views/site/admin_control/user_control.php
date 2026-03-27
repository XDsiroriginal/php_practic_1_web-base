<h1>Управление пользователями</h1>
<a href="<?= app()->route->getUrl('/admin_control/user_control/add_user') ?>">Добавить пользователя</a><br>
<?php
    foreach ($users as $user) {
        echo '<a href="#">'. $user->user_name .'</a>';
        echo '<br>';
    }
?>