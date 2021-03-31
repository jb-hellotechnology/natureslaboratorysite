<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	// echo $_SERVER['QUERY_STRING'];
	perch_layout('global.header'); 
	// Decides to show either the default hero or specific blog hero image
	// Need to add different options for the different sections?
	perch_content_create("Default Hero Image", array(
		"template" => 'blog_hero.html'
	));
	// perch_content_create("Sections", array(
	// 	"template" => "section.html"
	// ));

	$heroImageUrl = perch_content("Default Hero Image", true);
	$category = "blog/" . perch_get("section");
	if (perch_blog_post_field(perch_get('s'), 'heroImage', true)) {
		$heroImageUrl = perch_blog_post_field(perch_get('s'), 'heroImage', true);
	} else if (perch_get("section")) {
		$heroImageUrl = perch_blog_section(perch_get("section"), array(
			"template"=>"section_image.html"
		), true);;
	}
?>
    
		<div class="title-wrapper" style="background-image: url(
		<?php 
		echo $heroImageUrl; 
		
		?>
		);">
			<?php
			// Renders either the blog title or the default blog landing page title
			echo '<h1 class="span title">';
			if(perch_get('s')){   
				perch_blog_post_field(perch_get('s'), 'postTitle');
			} else if (perch_get('q')) {
				echo "Search";
			} else if (perch_get('section')) {
				perch_blog_section(perch_get("section"), array(
					"template"=>"section_title.html"
				));
			} else {
				echo 'The Nature\'s Laboratory Blog';
			}
			echo '</h1>';
			?>
		</div>
	    <div class="page-content">
			<div class="blog restrict <?php if($_SERVER["QUERY_STRING"]){ echo "narrow"; } ?>">


				<div class="blog-content-wrapper">
					
			    <?php 

			        if(perch_get('s')){
				        perch_blog_post(perch_get('s')); 
			        } else if (perch_get('q')) {
						perch_content_search(perch_get('q'), array(
							'count' => 5,
							'from-path' => '/blog',
							'excerpt-chars' => 300,
							'template' => 'search-result.html'
						));
					} else if (perch_get("section")) {
						perch_blog_custom(array(
							'count'      => 10,
							'template'   => 'post_in_list.html',
							'sort'       => 'postDateTime',
							'sort-order' => 'DESC',
							'section'    => perch_get("section"),
							'data' => [
								'section'=> perch_get("section")
							]
						  ));
					} else if (perch_get("tag")) {
						perch_blog_custom(array(
							'count'      => 10,
							'template'   => 'post_in_list.html',
							'sort'       => 'postDateTime',
							'sort-order' => 'DESC',
							'tag'=> perch_get("tag"),
							'data' => [
								'section'=> 'post'
							]
						  ));
					} else {
						perch_blog_sections(array(
							"template"=>"section_list.html",
							"include-empty"=>true,
							"cache"=>false
						));
					}
			    ?>
				</div>
			</div>
			<?php

				if (!$_SERVER["QUERY_STRING"]) {
					echo '<div class="blog restrict narrow">';
					echo '<div class="blog-content-wrapper">';
					echo "<h3>Recent Posts</h3>";
					perch_blog_custom(array(
						'count'      => 10,
						'template'   => 'post_in_list.html',
						'sort'       => 'postDateTime',
						'sort-order' => 'DESC',
						'data' => [
							'section'=>'post'
						]
						));
					echo "</div></div>";
				}

				?>
	    </div>

    <?php 
	    perch_layout('global.footer'); 
    ?>