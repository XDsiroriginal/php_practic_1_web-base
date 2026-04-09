<h1>Управление оборудованием</h1>

<input type="text" class="search">

<a href="">Добавить новое оборудование</a>

<ul>
    <?php foreach ($departments as $department):?>

    <li><?= $department->name?></li>
    <ul>
        <?php foreach ($equipments as $equipment):
            $status = $statuses->where('status_id', $equipment->status_id)->first
            ?>


        <li><?= $equipment->name  ?></li>
        <li><?= $equipment->model  ?></li>
        <li><?= $equipment->manufacturer  ?></li>
        <li><?= $equipment->cost  ?></li>
        <li><?= $status->name->name ?></li>
        <li><?= $equipment->updated_at?></li>


        <?php endforeach;?>
    </ul>

    <?php endforeach;?>
</ul>