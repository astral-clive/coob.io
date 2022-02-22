<?php
require_once('../includes/functions.php');

// grab arguments
$args = explode('/', $_SERVER['REQUEST_URI'] );

$hex_code = $args[1];

// validate hex code
if( !coob_validate_hex_code( $hex_code ) ){
    // @todo: present default image
    echo 'incorrect code';
    return;
}

$image = coob_generate_image( $hex_code );
if( !$image ){
    echo 'error creating';
    return;
}

var_dump( $image );





// $args[1] - hex code

