<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	perch_layout('global.header');
?>

<main>
    <div class="l-block">
        <div class="l-row">
            <div class="col-12 col-md-8 col-lg-6 col-centered">
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
        </div>
    </div>
</main>

<?php
    perch_layout('global.footer');
?>