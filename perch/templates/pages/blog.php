<?php include($_SERVER['DOCUMENT_ROOT'] . '/perch/runtime.php'); ?>
<?php

$title;
if (perch_get('s')) {
	$title = perch_blog_post_field(perch_get('s'), 'postTitle', true);
} else if (perch_get('q')) {
	$title = "Search";
} else if (perch_get('section')) {
	perch_blog_section(perch_get("section"), array(
		"template" => "section_title.html"
	), true);
} else {
	$title = 'News';
}

perch_layout('global.header', array(
	"title" => $title,
	"hero" => $heroImageUrl
));

?>
<main>
	<div class="l-block l-block--centered l-block--top-padding-small">
			<?php

			if (perch_get('s')) {
				perch_blog_post(perch_get('s'));
			} else {
				echo "<h1>News</h1>";
				perch_blog_custom(array(
					'count'      => 10,
					'template'   => 'post_in_list_card.html',
					'sort'       => 'postDateTime',
					'sort-order' => 'DESC',
					'data' => [
						'section' => 'post'
					]
				));
			}
			?>
	</div>
</main>



</div>

<?php
perch_layout('global.footer');
?>