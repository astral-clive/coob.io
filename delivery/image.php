<?php

// grab arguments

echo '<pre>';
var_dump($_SERVER);
echo '</pre>';

$args = explode('/', $_SERVER['REQUEST_URI'] );
echo '<pre>';
var_dump($args);
echo '</pre>';