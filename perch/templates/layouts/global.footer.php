
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
					<h2>Product Development</h2>
					<p>Nature's Laboratory lead the way in the research and development of effective natural health products.</p>
				</div>
				<div>
					<h2>Innovative Technology</h2>
					<p>Our in-house team develops purpose-built technology, advancing &amp; improving the production of natural medicines.</p>
				</div>
				<div>
					<p>Follow Us</p>
					<ul>
<!--
						<li><a href="#"><i class="fab fa-facebook"></i></a></li>
						<li><a href="#"><i class="fab fa-twitter"></i></a></li>
-->
						<li><a href="https://www.linkedin.com/company/natures-laboratory/"><i class="fab fa-linkedin"></i></a></li>
					</ul>
				</div>
				<div class="social">
					<form
					  action="https://buttondown.email/api/emails/embed-subscribe/jackbarber"
					  method="post"
					  target="popupwindow"
					  onsubmit="window.open('https://buttondown.email/jackbarber', 'popupwindow')"
					  class="embeddable-buttondown-form"
					>
					  <label for="bd-email">Subscribe to our Mailing List</label>
					  <input type="email" name="email" id="bd-email" placeholder="No spam, unsubscribe any time" />
					  <input type="submit" value="Subscribe" />
					</form>
				</div>
			</div>
		</aside>

	</main>
	
	<footer class="c-footer">
		<div class="l-wrap">
			<p class="copyright">
				<strong>Nature's Laboratory &mdash; <span>Home of Three-Dimensional Health</span></strong><br />
				&copy; Nature's Laboratory Limited <?php echo date('Y'); ?><br />
				Company Reg. 04375564 | <a href="/privacy/">Privacy</a> | <span>+44(0)1947 602346</span>
			</p>
			<ul>
				<li><a href="https://ecologi.com/natureslaboratory?r=61af6aa4f9550a84cf8be3d8" target="_blank" rel="noopener noreferrer" title="View our Ecologi profile"><img alt="We offset our carbon footprint via Ecologi" src="https://api.ecologi.com/badges/cpw/61af6aa4f9550a84cf8be3d8?black=true&landscape=true" /></a></li>
				<li><img src="/assets/images/living-wage.png" alt="Living Wage Employer" /></li>
				<li><img src="/assets/images/euorg.png" alt="Organic Supplier" /></li>
				<li><img src="/assets/images/cqs.png" alt="ISO2009:2015 Accredited" /></li>
				<li><img src="/assets/images/herbmark.svg" alt="HerbMark Accredited" /></li>
			</ul>
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