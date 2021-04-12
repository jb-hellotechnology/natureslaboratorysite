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
    <header class="c-hero c-hero--integrated-nav c-hero--dark l-wrap">
        <ul class="c-navigation-temp l-restrict l-restrict--wide">
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/">Home</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/about-us">About Us</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/research">Research</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/manufacturing">Manufacturing</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/join-us">Join Us</a></li>
            <li class="c-navigation-temp__element"><a class="c-navigation-temp__link" href="/contact">Contact</a></li>
        </ul>
        <div class="c-hero__title c-hero__title--no-bg">
            <img src="/perch/resources/natures-lab-logono-bg.png" alt="Nature's Laboratory Logo" class="c-hero__title-logo">
            <h1>
                The Immunity Community
            </h1>
        </div>
    </header>
    <div class="l-block">
        <div class="l-row c-home-top">
            <div class="c-home-top__logo-wrapper">
                <a href="https://herbalapothecaryuk.com/" class="c-home-top__logo-link"><img class="c-home-top__logo" src="/perch/resources/herbalapothecary.jpg" alt="Herbal Apothecary"></a>
                <a href="https://herbalapothecaryuk.com/" class="c-button c-button--centered c-home-top__button">Herbal Medicine</a>
            </div>
            <div class="c-home-top__logo-wrapper">
                <a href="http://www.beevitalpropolis.com/" class="c-home-top__logo-link"><img class="c-home-top__logo" src="/perch/resources/beevital.png" alt="Bee Vital"></a>
                <a href="http://www.beevitalpropolis.com/" class="c-button c-button--centered c-home-top__button">Apiceuticals</a>
            </div>
            <div class="c-home-top__logo-wrapper">
                <a href="https://www.sweetcecilys.com/" class="c-home-top__logo-link"><img class="c-home-top__logo" src="/perch/resources/sweet-cecilys-logo.svg" alt="Sweet Cecily's"></a>
                <a href="https://www.sweetcecilys.com/" class="c-button c-button--centered c-home-top__button">Natural Skincare</a>
            </div>
            <div class="c-home-top__logo-wrapper">
                <a href="http://www.threescompany.info/" class="c-home-top__logo-link"><img class="c-home-top__logo" src="/perch/resources/threes-company-logo-small.png" alt="Threes Company"></a>
                <a href="http://www.threescompany.info/" class="c-button c-button--centered c-home-top__button">Threes Company</a>
            </div>
            <div class="c-home-top__intro" style="background-image: url(/perch/resources/beeonflower.jpeg)">
                <div class="c-home-top__intro-mask">
                    <div class="c-home-top__intro_content l-flow">
                        <h2>The Wonder of Propolis</h2>
                        <p>
                            For 30 years we have been researching the medicinal properties of bee propolis. Propolis is a remarkable substance that bees use to keep their hives free from infection.
                        </p>
                        <p>
                            We started the International Propolis Research Group (IPRG) 6 years ago. In May it is holding its third international conference. This online conference will showcase clinical trials pertinent to the pandemic.
                            They illustrate how propolis can help with COVID and upper respiratory tract infection. Propolis is a remarkable substance. It has anti-bacterial and its anti-viral properties with proven health benefits for humans.
                        </p>
                        <p>
                            Register for the conference at conference.iprg.info.
                        </p>
                    </div>
                </div>
            </div>
            <div class="c-home-top__threes-description">
                <h2>Threes Company</h2>
                <p>
                    Threes Company emerged out of Nature’s Laboratory’s work in the community. For decades we have been developing social and cultural enterprises.
                    We want to create the sustainable business model the future needs.
                </p>
                <p>
                    Businesses need strong immune systems. Threes Company organisations understand the core concepts of social, economic and cultural health.
                    They are able to adapt and thrive in a rapidly changing environment.
                </p>
                <p>
                    Threes Company is an open concept available to all organisations. Looking for a livelier, healthier and more sustainable future for your organisation?
                </p>
                <p>
                    Visit www.threescompany.info.
                </p>
                <div class="c-home-top__threes-buttons">
                    <a href="https://futurehealthstore.com/" class="c-button">FutureHealth</a>
                    <a href="https://beearc.com/" class="c-button">BeeArc</a>
                </div>
            </div>
        </div>
    </div>
    <div class="l-block l-block--light-grey">
        <div class="l-row c-feature">
            <a href="https://hivechat.com">
                <svg class="c-feature__image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4509.84 1867.45">
                    <defs>
                        <style>
                            .cls-2 {
                                fill: #1264fa;
                            }
                        </style>
                    </defs>
                    <g id="Layer_2" data-name="Layer 2">
                        <g id="layers">
                            <rect class="cls-1" width="4509.84" height="1867.45" />
                            <path class="cls-2" d="M1316.52,1273.23v249.31h-46.3V1415.7H1141.29v106.84H1095V1273.23h46.3v102.93h128.93V1273.23Z" />
                            <path class="cls-2" d="M1597.16,1273.23h46.3v249.31h-46.3Z" />
                            <path class="cls-2" d="M2150.62,1273.23,2042,1522.54h-45.59l-109-249.31h50.22l83,192.33,83.69-192.33Z" />
                            <path class="cls-2" d="M2577.64,1483.72v38.82h-187V1273.23h182v38.82H2437v64.82h120.38V1415H2437v68.74Z" />
                            <path class="cls-2" d="M2824.1,1397.89c0-74.44,57-128.22,133.56-128.22,40.6,0,75.5,14.6,98.65,41.67l-29.92,28.14c-18.16-19.59-40.6-29.21-66.6-29.21-51.64,0-89,36.33-89,87.62s37.4,87.61,89,87.61c26,0,48.44-9.61,66.6-29.56l29.92,28.49c-23.15,27.07-58,41.67-99,41.67C2881.08,1526.1,2824.1,1472.32,2824.1,1397.89Z" />
                            <path class="cls-2" d="M3536,1273.23v249.31h-46.3V1415.7H3360.81v106.84h-46.3V1273.23h46.3v102.93h128.93V1273.23Z" />
                            <path class="cls-2" d="M3978.38,1464.84H3853.72l-24.57,57.7h-47.73l112.19-249.31h45.59l112.55,249.31h-48.44Zm-15.32-36.32-47-109-46.66,109Z" />
                            <path class="cls-2" d="M4335.24,1312.41h-82.63v-39.18h211.56v39.18h-82.63v210.13h-46.3Z" />
                            <path class="cls-2" d="M1061.49,603.34a78.86,78.86,0,0,0-39.27-68l-434-250.53a78.82,78.82,0,0,0-78.51,0L75.65,535.43a78.92,78.92,0,0,0-39.21,68v501.19a78.82,78.82,0,0,0,39.27,68l650.06,375.22a16.74,16.74,0,0,0,25.69-14.14V1328.91h0l270.86-156.39a78.87,78.87,0,0,0,39.21-68Z" />
                            <path class="cls-1" d="M238.78,702.31a47.69,47.69,0,0,1,23.75-41.13L525.21,509.52a47.78,47.78,0,0,1,47.53,0L835.46,661.19a47.76,47.76,0,0,1,23.73,41.16v303.36a47.76,47.76,0,0,1-23.75,41.13L442,1273.93a10.1,10.1,0,0,1-15.52-8.56v-123.9h0l-163.95-94.65a47.69,47.69,0,0,1-17.32-17.4,48.27,48.27,0,0,1-6.43-23.77Z" />
                            <path class="cls-2" d="M397.88,811.08a43.17,43.17,0,1,0,43.26,43.06A43,43,0,0,0,397.88,811.08Z" />
                            <path class="cls-2" d="M700.15,897.41a43.17,43.17,0,1,0-43.3-43.27A43.27,43.27,0,0,0,700.15,897.41Z" />
                            <path class="cls-2" d="M506,854.14a43.15,43.15,0,1,0,42.79-43.06A43,43,0,0,0,506,854.14Z" />
                        </g>
                    </g>
                </svg>
            </a>
            <div class="c-section c-feature__description">
                <div class="c-section__title">
                    <h2>HiveChat</h2>
                </div>
                <div class="c-section__content l-flow">
                    <p>Supporting healthy communities with easy to use tools for communication. Visit <span><a href="https://hivechat.com/">hivechat.com</a></span>.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="l-block">
        <div class="l-row">
            <div class="col-12 c-section c-section--center">
                <h2>The Immunity Community</h2>
                <p>The COVID-19 pandemic has reawakened the world to the delicate balance of nature.
                    It has reinforced our recognition of the complexity and beauty of nature.
                    It has reminded us how fragile we are. We’re exploring ways of supporting the health of people, organisations and communities.
                </p>
                <div class="c-text-columns">
                    <div class="c-text-columns__item">
                        <h4>Nature’s Immunity Community</h4>
                        <p class="c-text-columns__text">
                            Nature itself is a network of complex communities. An ecosystem which protects, balances, restores, and calibrates itself. It is its own immune defence mechanism.
                            But things can go wrong. Take, for example, Colony Collapse Disorder. This phenomenon illustrates what can happen when one of these communities experiences stress.
                            Stretching nature to breaking point can have devastating consequences.
                        </p>
                    </div>
                    <div class="c-text-columns__item">
                        <h4>The Human Immunity Community</h4>
                        <p class="c-text-columns__text">
                            Human immune systems are no different. Our immunity is easily compromised. Without a healthy immune system we leave ourselves prone to illness and disease.
                            A weakened immune system leaves an open door to viruses or bacteria. A robust immunity helps ward off illness and disease.
                        </p>
                    </div>
                    <div class="c-text-columns__item">
                        <h4>The Organisation’s Immunity Community</h4>
                        <p class="c-text-columns__text">
                            All organisations must find a balance between social, economic and cultural values. When one realm dominates the others the organisation’s health will suffer.
                        </p>
                    </div>
                    <div class="c-text-columns__item">
                        <h4>The Social & Cultural Immunity Community</h4>
                        <p class="c-text-columns__text">
                            Cultures and societies also have their own immune defence. These are also related to the social, economic and cultural realms within them. Without balance cultural
                            and societal health can become damaged.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="c-footer">
        <div class="l-restrict">
            <p class="copyright">© 2021</p>
        </div>
    </footer>
</body>

</html>