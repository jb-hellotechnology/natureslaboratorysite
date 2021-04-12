<?php include($_SERVER['DOCUMENT_ROOT'] . '/perch/runtime.php'); ?>
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
    <link rel="stylesheet" href="/assets/css/base.css?v=<?php echo rand(); ?>">
    <link rel="stylesheet" href="/assets/css/layout.css?v=<?php echo rand(); ?>">
    <link rel="stylesheet" href="/assets/css/components.css?v=<?php echo rand(); ?>">
    <link rel="stylesheet" href="/assets/css/stylesheet.css?v=<?php echo rand(); ?>">
</head>

<body>
    <header class="c-hero c-hero--integrated-nav c-hero--dark l-wrap c-navigation-temp">
        <!-- <button class="c-button c-navigation-temp__button hide">
            Menu
            <i class="fas fa-chevron-down"></i>
        </button>
        <ul class="c-navigation-temp__list l-restrict l-restrict--wide">
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/">Home</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/about-us">About Us</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/research">Research</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/manufacturing">Manufacturing</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/join-us">Join Us</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/contact">Contact</a></li>
        </ul> -->
        <div class="l-restrict c-banner">
            <div class="c-navigation" data-breakpoint="768" data-type="dynamic">
                <?php
                    perch_pages_navigation(array(
                        'template' => array('topNavMain.html', 'topNavSub.html')
                    ));
                ?>
                <div class="c-hamburger hide">
                    <button class="c-hamburger__button">
                        <div class="c-hamburger__line"></div>
                        <div class="c-hamburger__line"></div>
                        <div class="c-hamburger__line"></div>
                    </button>
                    <?php
                        perch_pages_navigation(array(
                            'template' => array('hamburgerMain.html', 'hamburgerSub.html')
                        ))
                    ?>
                </div>
            </div>
        </div>
    <?php
                perch_content_create("Home Content", ["template" => "home.html"]); 
                perch_content("Home Content");
            ?>
<?php

perch_layout("global.footer");

?>