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

	<link rel="preconnect" href="https://kit.fontawesome.com" crossorigin />

	<link rel="stylesheet" href="/assets/fonts/Noway-Medium-Italic-webfont/stylesheet.css">
	<link rel="stylesheet" href="/assets/fonts/Noway-Medium-webfont/stylesheet.css">
	<link rel="stylesheet" href="/assets/fonts/Noway-Regular-Italic-webfont/stylesheet.css">
	<link rel="stylesheet" href="/assets/fonts/Noway-Regular-webfont/stylesheet.css">
	
	<link href="/assets/fonts/fontawesome/css/all.css" rel="stylesheet">
	
	<link rel="stylesheet" href="/assets/css/stylesheet.css?v=<?php echo rand(); ?>">
</head>

<body>	
	<header class="c-hero">
	    <div class="l-wrap">
	        <?php
		        perch_content('Header');
		    ?>
		    <div class="c-navigation">
		        
		        <?php
		        perch_pages_navigation(array(
		            'template' => array('topNavMain.html', 'topNavSub.html')
		        ));
		        ?>
		        <div class="c-hamburger hide">
		            <button class="c-hamburger__button">
		                <!-- <div class="c-hamburger__line"></div>
		                <div class="c-hamburger__line"></div>
		                <div class="c-hamburger__line"></div> -->
		                Menu
		            </button>
		            <?php
		            perch_pages_navigation(array(
		                'template' => array('hamburgerMain.html', 'hamburgerSub.html')
		            ))
		            ?>
		        </div>
		    </div>
	    </div>
	</header>
	<?php
	
	?>
	<main>
		<div class="l-wrap">