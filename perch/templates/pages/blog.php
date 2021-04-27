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

perch_content_create("Default Hero Image", array(
	"template" => 'blog_hero.html'
));

$heroImageUrl = perch_content("Default Hero Image", true);
$category = "blog/" . perch_get("section");
if (perch_blog_post_field(perch_get('s'), 'heroImage', true)) {
	$heroImageUrl = perch_blog_post_field(perch_get('s'), 'heroImage', true);
} else if (perch_get("section")) {
	$heroImageUrl = perch_blog_section(perch_get("section"), array(
		"template" => "section_image.html"
	), true);;
}

perch_layout('global.header', array(
	"title" => $title,
	"hero" => $heroImageUrl
));

?>
<main>
	<div class="l-block l-block--centered l-block--top-padding-small">
			<?php
			function postListBefore() {
				echo '<div class="l-row">';
				echo '<div class="col-lg-6 col-md-8 col-sm-10 col-centered col-12 c-posts">';
			}

			function postListAfter() {
				echo "</div></div>";
			}

			function slugToString($slug) {
				$splitSlug = explode("-", $slug);
				return ucwords(join(" ", $splitSlug));
			}

			if (perch_get('s')) {
				perch_blog_post(perch_get('s'));
			} else if (perch_get('q')) {
				perch_content_search(perch_get('q'), array(
					'count' => 5,
					'from-path' => '/news',
					'excerpt-chars' => 300,
					'template' => 'search-result.html'
				));
			} else if (perch_get("section")) {
				
				postListBefore();
				perch_blog_custom(array(
					'count'      => 10,
					'template'   => 'post_in_list_card.html',
					'sort'       => 'postDateTime',
					'sort-order' => 'DESC',
					'section'    => perch_get("section"),
					'data' => [
						'section' => perch_get("section")
					]
				));
				postListAfter();
			} else if (perch_get("tag")) {
				postListBefore();
				perch_blog_custom(array(
					'count'      => 10,
					'template'   => 'post_in_list_card.html',
					'sort'       => 'postDateTime',
					'sort-order' => 'DESC',
					'tag' => perch_get("tag"),
					'data' => [
						'section' => 'post'
					]
				));
				postListAfter();
			} else if (perch_get("author")){
				postListBefore();
				echo "<h3>Posts by " . slugToString(perch_get("author")) . "</h3>";
				perch_blog_custom(array(
					'count'      => 10,
					'template'   => 'post_in_list_card.html',
					'sort'       => 'postDateTime',
					'sort-order' => 'DESC',
					'author' => perch_get("author")
				));
				postListAfter();
			} else {
				perch_blog_sections(array(
					"template" => "section_list.html",
					"include-empty" => true,
					"cache" => false
				));
			}
			?>
	</div>
	<?php

	if (!$_SERVER["QUERY_STRING"]) {
		echo '<div class="l-block l-block--no-top-padding">';
		echo '<div class="l-row">';
		echo '<div class="col-lg-8 col-md-10 col-sm-12 col-centered col-12 c-posts">';
		echo "<h3>Recent Posts</h3>";
		perch_blog_custom(array(
			'count'      => 10,
			'template'   => 'post_in_list_card.html',
			'sort'       => 'postDateTime',
			'sort-order' => 'DESC',
			'data' => [
				'section' => 'post'
			]
		));
		echo "</div></div></div>";
	}

	?>
</main>



</div>

<?php
perch_layout('global.footer');
?>