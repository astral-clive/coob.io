<?php
require_once __DIR__.'/../vendors/php-svg/autoloader.php';
use SVG\SVG;
use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Shapes\SVGRect;

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

//function coob_generate_image($hex_code = false, $width = false, $height = false, $border_radius = false ){
//    if( !$hex_code ) return false;
//    $get_rgb = coob_hex_to_rgb( $hex_code );
//    if( !$get_rgb ) return false;
//    if( !array_key_exists('red', $get_rgb )
//        || !array_key_exists('green', $get_rgb )
//        || !array_key_exists( 'blue', $get_rgb )
//    ) return false;
//
//    // generate values
//    $width = $width ?: 32;
//    $height = $height ?: $width;
//    if( !$border_radius ){
//        $border_radius = ( $width <= 32 && $height <= 32 ) ? 5 : false;
//        if( !$border_radius ){
//            if( $width >= $height ){
//                $border_radius = float($width*0.15);
//            } else {
//                $border_radius = float($height*0.15);
//            }
//        }
//    }
//
//    // create the canvas
//    $image = imagecreatetruecolor( $width, $height );
//
//    // set the color
//    $forefront_color = imagecolorallocate( $image,  $get_rgb['red'], $get_rgb['green'], $get_rgb['blue']);
//
//    // make background transparent
//    $canvas_background = imagecolorallocate($image, 0, 0, 0);
//    imagecolortransparent($image, $canvas_background);
//
//    // draw rectangles
//    // __ horizontal
//    imagefilledrectangle($image, 0, $border_radius, $width, $height-$border_radius, $forefront_color);
//    // __ vertical
//    imagefilledrectangle($image, $border_radius, 0, $width-$border_radius, $height, $forefront_color);
//
//    // draw circles
//    // __ top left
//    imagefilledellipse($image, $border_radius, $border_radius, $border_radius*2, $border_radius*2, $forefront_color );
//    // __ top right
//    imagefilledellipse($image, $width-$border_radius, $border_radius, $border_radius*2, $border_radius*2, $forefront_color );
//    // __ bottom right
//    imagefilledellipse($image, $border_radius, $height-$border_radius, $border_radius*2, $border_radius*2, $forefront_color );
//    // __ bottom left
//    imagefilledellipse($image, $width-$border_radius, $height-$border_radius, $border_radius*2, $border_radius*2, $forefront_color );
//
//
//
//    header('Content-type: image/png');
//
//
////    // alpha blending - transparency
////    imagealphablending($image, false);
////    imagesavealpha($image, true);
//
//    imagepng($image);
//}

function coob_generate_svg( $hex_code = false, $width = false, $height = false, $border_radius = false ){
    if( !$hex_code ) return false;

    // generate values
    $width = $width ?: 64;
    $height = $height ?: $width;
    if( !$border_radius ){
        $border_radius = ( $width <= 64 && $height <= 64 ) ? 5 : false;
        if( !$border_radius ){
            if( $width >= $height ){
                $border_radius = round($width*0.15);
            } else {
                $border_radius = round($height*0.15);
            }
        }
    }


    // create canvas
    $image = new SVG( $width, $height );
    $doc = $image->getDocument();

    // draw rectangles
    // __ horizontal
    $rectangle_h = new SVGRect(0, $border_radius, $width, $height-($border_radius*2));
    $rectangle_h->setStyle('fill', '#'. $hex_code );
    $doc->addChild($rectangle_h);
    // __ vertical
    $rectangle_v = new SVGRect($border_radius, 0, $width-($border_radius*2), $height);
    $rectangle_v->setStyle('fill', '#'. $hex_code );
    $doc->addChild($rectangle_v);

    // draw circles
    // __ top left
    $doc->addChild(
        (new SVGCircle($border_radius, $border_radius, $border_radius))
            ->setStyle('fill', '#'. $hex_code)
    );
    // __ top right
    $doc->addChild(
        (new SVGCircle($width-$border_radius, $border_radius, $border_radius))
            ->setStyle('fill', '#'. $hex_code)
    );
    // __ bottom right
    $doc->addChild(
        (new SVGCircle($width-$border_radius, $height-$border_radius, $border_radius))
            ->setStyle('fill', '#'. $hex_code)
    );
    // __ bottom left
    $doc->addChild(
        (new SVGCircle($border_radius, $height-$border_radius, $border_radius))
            ->setStyle('fill', '#'. $hex_code)
    );


    header('Content-Type: image/svg+xml');
    echo $image;

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