<h1>Список статей</h1>
<ol>
    <?php
    foreach ($posts as $post) {
        echo '<ul>';
        echo '<li>' . $post->title . '</li>';
        echo '<li>' . $post->descript . '</li>';
        echo '<li>' . $post->data . '</li>';
        echo '</ul>';
        echo '<br>';
    }
    ?>
</ol>