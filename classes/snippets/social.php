<?php
array_map(function($obj) {
	$classes = implode(' ', $obj->classes);

	echo <<<S
<a href="$obj->url" target="_blank" class="$classes">
	$obj->title
</a> 
S;
}, wp_get_nav_menu_items(23));