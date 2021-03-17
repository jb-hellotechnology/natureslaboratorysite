<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	perch_layout('global.header'); 
?>
    
    <div class="wrap">
		<div class="restrict title-wrapper">
			<?php
			echo '<div class="blog-post-header"><a href="/blog/">
					<h3 class="title-small">';
			if (perch_get('s')) {
				echo 'The Nature\'s Laboratory Blog';
			}
			echo '</h3></a>
					<div class="navigation">';
					perch_pages_navigation();
					if (perch_get('s')) {
						perch_layout('search');
					}
			echo '</div></div>';
			
			?>
			<?php
			if(!perch_get('s')){   
				echo '<h1 class="span title">The Nature\'s Laboratory Blog</h1>';
			}
			?>
		</div>
		<div class="restrict aside-wrapper" style="<?php if (perch_get('s')){ echo "display: none"; } ?>">
			<aside>
				<?php
					perch_layout('search');
				?>

				<?php 
					perch_blog_categories(); 
				?>
		
				<?php 
					perch_blog_custom(array(
					'count'      => 10,
					'template'   => 'post_in_list_minimal.html',
					'sort'       => 'postDateTime',
					'sort-order' => 'DESC',
					'section'    => 'posts'
					));
				?>
				
				<?php 
					perch_blog_tags();
				?>

			</aside>
		</div>
	    <div class="restrict">
			<div class="blog">


				<div class="blog-content-wrapper">
					
			    <?php 
			        if(perch_get('s')){
				        perch_blog_post(perch_get('s')); 
			        }else{
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
				<div class="break"></div>

			    
			    
			</div>
	    </div>
    </div>

    <?php 
	    perch_layout('global.footer'); 
    ?>