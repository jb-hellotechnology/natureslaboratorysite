<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	perch_layout('global.header'); 
?>
    
    <div class="wrap">
		<div class="restrict title-wrapper">
			<?php
			echo '<h1 class="span title">';
			if(!perch_get('s')){   
				echo 'The Nature\'s Laboratory Blog';
			} else {
				perch_blog_post_field(perch_get('s'), 'postTitle');
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