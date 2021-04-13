<?php 
include($_SERVER['DOCUMENT_ROOT'] . '/perch/runtime.php'); 

perch_layout("global.header");

perch_content_create("Home Content", ["template" => "home.html"]);
perch_content("Home Content");

perch_layout("global.footer");

?>