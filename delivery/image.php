<?php
require_once('../includes/functions.php');

// grab arguments
$args = explode('/', $_SERVER['REQUEST_URI'] );

/**
 * $args
 * [1] hex code
 */

$hex_code = $args[1];
$hex_code = coob_sanitize_hex( $hex_code );

// validate hex code
if( !coob_validate_hex_code( $hex_code ) ){
    // @todo: create placeholder to show error, perhaps question mark
    $image = coob_generate_svg( 'f00', 32, 32 );
}

$size = 64; // px (width and height)
$image = coob_generate_svg( $hex_code, $size, $size );

if( !$image ){
    echo 'error creating';
}