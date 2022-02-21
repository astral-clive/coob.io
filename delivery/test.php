<?php


$args = array_filter( explode('/', $_SERVER['REQUEST_URI'] ) );

foreach( $args as $arg ){
    echo '<br>'. $arg;
}
