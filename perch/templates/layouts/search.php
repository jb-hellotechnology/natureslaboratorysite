<?php
    $action = "search";
    $placeholder = "Search Keyword";
    $uriArray = explode("/", $_SERVER['REQUEST_URI']);
    foreach ($uriArray as $str) {
        if ($str == "blog") {
            $action = "blog";
            $placeholder ="Search Blog";
        }
    }
?>

<form method="get" action="/<?php echo $action ?>" class="search">
    <div class="form-group">
        <div>
            <input type="text" placeholder="<?php echo $placeholder ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Keyword'" name="q">
        </div>
    </div>
    <input type="submit" value="Search" class="form-button" />
</form>