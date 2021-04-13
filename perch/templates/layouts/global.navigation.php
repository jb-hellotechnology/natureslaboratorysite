<div class="l-restrict c-banner">
    <div class="c-navigation" data-breakpoint="768" data-type="dynamic">
        
        <?php
        $isHome = false;
        if ($_SERVER["REQUEST_URI"] == "/") {
            $isHome = true;
        }
        perch_content_custom("Icon", ["data" => ["isHome" => $isHome]]);
        
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