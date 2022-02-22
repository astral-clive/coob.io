<?php

function coob_validate_hex_code($str){
    return preg_match('/^#?([a-f0-9]{3}){1,2}\b$/i', $str);
}

function coob_hex_to_rgb( $hex_code = false , $return_as_string = false, $seperator =',' ){
    if( !$hex_code ) return false;
    $hex_code = preg_replace("/[^0-9A-Fa-f]/", '', $hex_code); // Gets a proper hex string
    $rgb_array = array();
    if (strlen($hex_code) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hex_code);
        $rgb_array['red'] = 0xFF & ($colorVal >> 0x10);
        $rgb_array['green'] = 0xFF & ($colorVal >> 0x8);
        $rgb_array['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hex_code) == 3) { //if shorthand notation, need some string manipulations
        $rgb_array['red'] = hexdec(str_repeat(substr($hex_code, 0, 1), 2));
        $rgb_array['green'] = hexdec(str_repeat(substr($hex_code, 1, 1), 2));
        $rgb_array['blue'] = hexdec(str_repeat(substr($hex_code, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $return_as_string ? implode($seperator, $rgb_array) : $rgb_array; // returns the rgb string or the associative array
}

function coob_generate_image($hex_code = false, $width = 32, $height = 32){
    if( !$hex_code ) return false;
    $get_rgb = coob_hex_to_rgb( $hex_code );
    if( !$get_rgb ) return false;
    if( !array_key_exists('red', $get_rgb )
        || !array_key_exists('green', $get_rgb )
        || !array_key_exists( 'blue', $get_rgb )
    );

    // create the canvas
    $image = imagecreatetruecolor( $width, $height );
    // set the color
    $background_color = imagecolorallocate( $image,  $get_rgb['red'], $get_rgb['green'], $get_rgb['blue']);
    // use that color to fill
//    imagefill( $image, 0, 0, $background_color );

    // polygon
    // Allocate a color for the polygon
    $image_color = imagecolorallocate($image, $get_rgb['red'], $get_rgb['green'], $get_rgb['blue'] );

    // Draw the polygon
    $points = array(
        $width,  0, // Point 1 (x, y)
        $width,  $height,  // Point 2 (x, y)
        0, $height // Point 3 (x, y)
    );
    imagefilledpolygon($image, $points, 3, $image_color);

    header('Content-type: image/png');
    imagepng($image);
}