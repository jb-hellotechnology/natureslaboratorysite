<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	perch_layout('global.header'); 
	perch_content_create("Default Hero Image", array(
		"template" => 'blog_hero.html'
	));
	$heroImageUrl = perch_content("Default Hero Image", true);
	if (perch_blog_post_field(perch_get('s'), 'heroImage', true)) {
		$heroImageUrl = perch_blog_post_field(perch_get('s'), 'heroImage', true);
	}
?>
    
		<div class="title-wrapper <?php if(!perch_get('s') && !perch_get('q')){ echo "main"; } ?>" style="background-image: url(<?php echo $heroImageUrl ?>);">
			<?php
			echo '<h1 class="span title">';
			if(perch_get('s')){   
				perch_blog_post_field(perch_get('s'), 'postTitle');
			} else if (perch_get('q')) {
				echo "Search";
			} else {
				echo 'The Nature\'s Laboratory Blog';
			}
			echo '</h1>';
			?>
		</div>
		<div class="restrict aside-wrapper" style="<?php if (true){ echo "display: none"; } ?>">
			<!-- <aside>

				<?php 
					// perch_blog_categories(); 
				?>
		
				<?php 
					// perch_blog_custom(array(
					// 'count'      => 10,
					// 'template'   => 'post_in_list_minimal.html',
					// 'sort'       => 'postDateTime',
					// 'sort-order' => 'DESC',
					// 'section'    => 'posts'
					// ));
				?>
				
				<?php 
					// perch_blog_tags();
				?>

			</aside> -->
		</div>
	    <div>
			<div class="blog restrict narrow">


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
					} else {
				        perch_blog_custom(array(
						  'count'      => 10,
						  'template'   => 'post_in_list.html',
						  'sort'       => 'postDateTime',
						  'sort-order' => 'DESC',
						  'section'    => 'posts'
						));
			       	}
			    ?>
				</div>

			    
			    
			</div>
	    </div>

    <?php 
	    perch_layout('global.footer'); 
    ?>