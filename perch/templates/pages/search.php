<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	perch_layout('global.header');
?>

<?php
    
	$query = perch_get('q');
    perch_content_search($query, array(
        'count' => 5,
        'from-path' => '/blog',
        'excerpt-chars' => 300,
        'template' => 'search-result.html'
    ));

?>

<?php
    perch_layout('global.footer');
?>