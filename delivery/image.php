<?php
require_once('../includes/functions.php');

// grab arguments
$args = explode('/', $_SERVER['REQUEST_URI'] );

/**
 * $args
 * [1] hex code
 */

$hex_code = $args[1];

// validate hex code
if( !coob_validate_hex_code( $hex_code ) ){
    $image = coob_generate_image( 'f00', 32, 32 );
}

$image = coob_generate_image( $hex_code, 32, 32 );
if( !$image ){
    echo 'error creating';
}