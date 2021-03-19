<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php 
	perch_layout('global.header'); 
	perch_content_create("Hero", array(
		"template" => 'hero.html'
	));
?>

<?php
	perch_content("Hero");
?>

<div class="content">
	<?php 
		perch_content('Page Content'); 
	?>
</div>


<?php perch_layout('global.footer'); ?>