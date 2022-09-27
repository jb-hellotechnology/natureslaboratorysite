		</div>
		
		<aside>
			<div class="l-wrap">
				<?php
					perch_blog_custom(array(
						'count'      => 1,
						'template'   => 'post_in_list_card_home.html',
						'sort'       => 'postDateTime',
						'sort-order' => 'DESC',
						'data' => [
							'section' => 'post'
						]
					));
				?>
				<div>
					<h2>Development</h2>
					<p>Nature's Laboratory lead the way in the research and development of effective natural health products.</p>
				</div>
				<div>
					<h2>Technology</h2>
					<p>Our in-house team develops purpose-built technology, advancing &amp; improving the production of natural medicines.</p>
				</div>
			</div>
		</aside>

	</main>
	
	<footer class="c-footer">
		<div class="l-wrap">
			<p class="copyright">&copy; Nature's Laboratory Limited <?php echo date('Y'); ?></p>
		</div>
	</footer>
	</body>
	<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
	<script>
		$('.c-hamburger button').click(function(){
			$('.c-hamburger.hide ul').toggleClass('show');
		})
	</script>
	</html>