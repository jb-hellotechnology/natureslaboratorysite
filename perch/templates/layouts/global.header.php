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
	
	<link rel="stylesheet" href="/assets/css/stylesheet.css?v=<?php echo rand(); ?>">
</head>

<body>	
	<?php
		perch_content_create("Header", ["template" => "header.html"]);

		$options = [
			"data" => []
		];
		
		if (perch_layout_var("title", true)) {
			$options["data"]["customTitle"] = perch_layout_var("title", true);
		}
		
		if (perch_layout_var("hero", true)) {
			$options["data"]["customHero"] = perch_layout_var("hero", true);
		}

		perch_content_custom("Header", $options);
	?>
	<main class="l-wrap">