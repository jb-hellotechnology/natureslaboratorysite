<?php 
include($_SERVER['DOCUMENT_ROOT'] . '/perch/runtime.php'); 

perch_layout("global.header");

PerchSystem::set_var('SUPPLIER_REF', $_GET['id']);
?>
<style>
label{
	display:block;
	max-width:60ch;
	margin-top:1rem;
}	

select{
	display:block;
	max-width:60ch;
}

input[type=submit]{
	margin-bottom:4rem;
	display:block;
}

h2{
	margin-top:1rem;
	font-size:1.6rem;
}

main{
	max-width:60ch;
	margin:0 auto;
	display:block;
}
</style>
<main>
	<?php 
		perch_content('Page Content'); 
		perch_form('supplier');
	?>
</main>

<?php

perch_layout("global.footer");

?>

 <?php PerchUtil::output_debug(); ?>