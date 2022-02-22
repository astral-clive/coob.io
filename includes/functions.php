<?php

function coob_validate_hex_code($str){
    return preg_match('/^#?([a-f0-9]{3}){1,2}\b$/i', $str);
}

function adjustBrightness($hex_code = false, $adjustPercent = 0.1) {
    if( !$hex_code ) return false;
    $hex_code = ltrim($hex_code, '#');

    // if hex is 3 characters, make it into 6 character
    if (strlen($hex_code) == 3) {
        $hex_code = $hex_code[0] . $hex_code[0] . $hex_code[1] . $hex_code[1] . $hex_code[2] . $hex_code[2];
    }

    // https://www.php.net/manual/en/function.hexdec.php
    $hex_code = array_map('hexdec', str_split($hex_code, 2));

    foreach ($hex_code as & $color_value) {
        $adjustableLimit = $adjustPercent < 0 ? $color_value : 255 - $color_value;
        $adjustAmount = ceil($adjustableLimit * $adjustPercent);
        $color_value = str_pad(dechex($color_value + $adjustAmount), 2, '0', STR_PAD_LEFT);    }

    return '#' . implode($hex_code);
}

function coob_sanitize_hex( $hex_code = false ){
    if( !$hex_code ) return false;
    // sanitize hex_code
    $hex_code = preg_replace("/[^a-zA-Z0-9]+/", "", $hex_code);
    $hex_code_length = strlen($hex_code);
    if( $hex_code_length !== 3 && $hex_code_length !== 6 ){
        $hex_code = ( $hex_code_length > 6 ? substr( $hex_code, 0, 3 ) : substr( $hex_code, 0, 6 ) );
    }
    $hex_code = (substr( $hex_code, 0, 1 ) !== '#' ) ? '#'. $hex_code : $hex_code;
    return $hex_code;
}

function coob_generate_svg( $hex_code = false, $width = false, $height = false, $border_radius = false, $shadow = false ){
    if( !$hex_code ) return false;

    // generate values
    $width = $width ?: 64;
    $height = $height ?: $width;
    $border_radius = $border_radius ?: 5;
    $shadow = $shadow ?: 5;
    $hex_code = (substr( $hex_code, 0, 1 ) !== '#' ) ? '#'. $hex_code : $hex_code;

    header('Content-Type: image/svg+xml');
    ob_start();

    echo '<?xml version="1.0" encoding="utf-8"?>';
    echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="'. ( $width+($shadow*2) ) .'" height="'. ( $height+($shadow*2) ) .'" >';

    // definitions
    echo '<defs>';
    echo '<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%" gradientUnits="userSpaceOnUse">';
    echo '<stop offset="0%" style="stop-color:'. adjustBrightness( $hex_code, 0.2) .';stop-opacity:1" />';
    echo '<stop offset="100%" style="stop-color:'. $hex_code .';stop-opacity:1" />';
    echo '</linearGradient>';
    echo '<filter id="shadow">';
    echo '<feDropShadow dx="0" dy="0" stdDeviation="5" flood-color="rgba(0,0,0,0.2)"></feDropShadow>';
    echo '</filter>';
    echo '</defs>';

    echo '<g id="coob" style="fill: url(#shape-gradient)">';

    // rectangles
    // __ horizontal
    echo '<rect x="0" y="'. $border_radius .'" width="'. $width .'" height="'. ($height-($border_radius*2)) .'" style="fill: url(#gradient)"/>';
    // __ vertical
    echo '<rect x="'. $border_radius .'" y="0" width="'. ($width-($border_radius*2)) .'" height="'. $height .'" style="fill: url(#gradient)"/>';
    // __ shadow
    // @todo: add drop shadow
    //    echo '<rect x="'. $shadow .'" y="'. $shadow .'" width="'. $width .'" height="'. $height .'" filter="url(#shadow)" style="fill: #f00"/>';

    // circles
    // __ top left
    echo '<circle cx="'. $border_radius .'" cy="'. $border_radius .'" r="'. $border_radius .'" style="fill: url(#gradient)"/>';
    // __ top right
    echo '<circle cx="'. ( $width - $border_radius ) .'" cy="'. $border_radius .'" r="'. $border_radius .'" style="fill: url(#gradient)"/>';
    // __ bottom right
    echo '<circle cx="'. ( $width - $border_radius ) .'" cy="'. ( $height - $border_radius ) .'" r="'. $border_radius .'" style="fill: url(#gradient)"/>';
    // __ bottom left
    echo '<circle cx="'. $border_radius .'" cy="'. ( $height - $border_radius ) .'" r="'. $border_radius .'" style="fill: url(#gradient)"/>';

    echo '</g>'; // #coob

    echo '</svg>';

    echo ob_get_clean();

    exit;
}


function image_rectangle_w_rounded_corners(&$im, $x1, $y1, $x2, $y2, $radius, $color) {
    $alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);

    // draw rectangle without corners
    imagefilledrectangle($im, $x1+$radius, $y1, $x2-$radius, $y2, $color);
    imagefilledrectangle($im, $x1, $y1+$radius, $x2, $y2-$radius, $color);

    // draw circled corners
    imagefilledellipse($im, $x1+$radius, $y1+$radius, $radius*2, $radius*2, $color);
    imagefilledellipse($im, $x2-$radius, $y1+$radius, $radius*2, $radius*2, $color);
    imagefilledellipse($im, $x1+$radius, $y2-$radius, $radius*2, $radius*2, $color);
    imagefilledellipse($im, $x2-$radius, $y2-$radius, $radius*2, $radius*2, $color);

    // alpha radius bg
    $width = imagesx($im);
    $height = imagesy($im) - 0.01;

    imagefill($im, 0, 0, $alpha);
    imagefill($im, $width, 0, $alpha);
    imagefill($im, 0, $height, $alpha);
    imagefill($im, $width, $height, $alpha);
}