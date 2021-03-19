<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	perch_layout('global.header');
?>

<div class="restrict narrow">
    <?php

    $query = perch_get('q');
    perch_content_search($query, array(
        'count' => 5,
        'from-path' => '/',
        'excerpt-chars' => 300,
        'template' => 'search-result.html'
    ));

    ?>
</div>

<?php
    perch_layout('global.footer');
?>