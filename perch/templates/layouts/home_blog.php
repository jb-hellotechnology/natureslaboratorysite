<?php
    perch_blog_custom([
        "template" => "home_post.html",
        "filter" => "postSlug",
        "value" => perch_layout_var("slug", true)
    ])

?>