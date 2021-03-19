<!doctype html>
<html lang="en-gb">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php
	if (perch_get('s')) {
		perch_blog_post_meta(perch_get('s'));
	} else {
	?>
		<title><?php perch_pages_title(); ?></title>
		<?php perch_page_attributes(); ?>
	<?php
	}
	?>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
	<link rel="preconnect" href="https://kit.fontawesome.com" crossorigin />

	<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400;1,700&display=swap" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400;1,700&display=swap" media="print" onload="this.media='all'" />
	<noscript>
		<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
	</noscript>
	<link rel="stylesheet" href="/assets/css/stylesheet.css?v=<?php echo rand(); ?>">
</head>

<body>
	<header>
		
			<?php
			// $isBlog = perch_page_attribute('pageNavText', array(), true) == "Blog";

			// echo '<div class="blog-post-header restrict"><a href="';
			// if ($isBlog) {
			// 	echo '/blog/">';
			// } else {
			// 	echo '/">';
			// }

			// echo '<h3 class="title-small">';
			// if ($isBlog) {
			// 	echo 'The Nature\'s Laboratory Blog';
			// } else {
			// 	echo 'Nature\'s Laboratory';
			// }
			// echo '</h3></a>

			// <div class="navigation">';
			// perch_pages_navigation([
			// 	'template' => 'blog_nav.html',
			// 	'hide-default-doc' => true
			// ]);
			// perch_layout('search');

			// echo '</div></div>';

			
			?>
		
		<div class="restrict">
			<h3 class="title-small">
				<?php
					$isBlog = perch_page_attribute('pageNavText', array(), true) == "Blog";
					if ($isBlog) {
						echo 'The Nature\'s Laboratory Blog';
					} else {
						echo 'Nature\'s Laboratory';
					}
				?>
			</h3>
			<nav class="navigation">
				<?php
				perch_pages_navigation(array(
					'template' => array('topNavMain.html', 'topNavSub.html')
				));
				?>
				<div class="hamburgerWrapper">
					<button class="hamburgerButton">
						<i class="fas fa-bars"></i>
					</button>
					<?php
					perch_pages_navigation(array(
						'template' => array('hamburgerMain.html', 'hamburgerSub.html')
					))
					?>
				</div>
			</nav>
		</div>
	</header>
	<div class="wrap">