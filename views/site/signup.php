<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<?php

if (empty($message)) {
    echo '<form method="post">
    <label>Имя <input type="text" name="name"></label>
    <label>Логин <input type="text" name="user_name"></label>
    <label>Пароль <input type="password" name="password"></label>
    <label>Кафедра 
        <select name="department_id">';
            foreach ($departments as $department) {
                echo '<option value="' . $department->department_id . '">' . $department-> description . '</option>';
            }
    echo '
        </select>
    </label>
    <button>Зарегистрироваться</button>
</form>';
}

?>

