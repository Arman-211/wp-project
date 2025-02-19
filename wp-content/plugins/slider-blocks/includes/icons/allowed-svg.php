<?php

/**
 * The function `gutslider_allowed_svg_tags` defines an array of allowed SVG tags and their attributes
 * for use in a PHP application.
 * 
 * @return An array of allowed SVG tags and their attributes is being returned. The 'svg' tag allows
 * attributes such as class, aria-hidden, aria-labelledby, role, xmlns, width, height, and viewbox. The
 * 'g' tag allows the fill attribute. The 'title' tag allows the title attribute. The 'path' tag allows
 * the d and fill attributes.
 */
function gutslider_allowed_svg_tags() {
    return array(
        'svg'   => array(
            'class'           => true,
            'aria-hidden'     => true,
            'aria-labelledby' => true,
            'role'            => true,
            'xmlns'           => true,
            'width'           => true,
            'height'          => true,
            'viewbox'         => true, // <= Must be lower case!
        ),
        'g'     => array( 'fill' => true ),
        'title' => array( 'title' => true ),
        'path'  => array(
            'd'    => true,
            'fill' => true,
        ),
    );
}