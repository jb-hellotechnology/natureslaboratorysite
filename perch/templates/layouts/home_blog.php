<?php
    perch_blog_custom([
        "template" => "post_in_list_card.html",
        "filter" => "postSlug",
        "value" => perch_layout_var("slug", true),
        "data" => [
            "type" => "home"
        ]
    ])

?>