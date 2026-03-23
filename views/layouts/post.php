<h1>Список статей</h1>
<ol>
    <?php
    foreach ($posts as $post) {
        echo '<div>';
        echo '<h2>' . $post->title . '</h2>';
        echo '<p>' . $post->descript . '</p>';
        echo '<p>' . $post->data . '</p>';
        echo '</div>';
    }
    ?>
</ol>