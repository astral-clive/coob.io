<?php

// grab arguments
echo 'image.php found';

$args = explode('/', $_SERVER['REQUEST_URI'] );
echo '<pre>';
var_dump($args);
echo '</pre>';