<?php

class td_external_resources {

    private static $styles_loaded = array();
    private static $scripts_loaded = array();




    /**
     * Render a style
     * @param string $style_href
     * @return string
     */
    static function render_style( $style_href, $tag_id = '' ) {

        if( !in_array( $style_href, self::$styles_loaded ) ) {
            self::$styles_loaded[] = $style_href;

            return '<link rel="stylesheet"' . ( $tag_id != '' ? ' id="' . $tag_id . '"' : '' ) . ' href="' . $style_href . '" type="text/css" />';
        }

        return '';

    }




    /**
	 * Render a script
     * @param string $script_src
     * @return string
     */
    static function render_script( $script_src, $tag_id = '' ) {

        if( !in_array( $script_src, self::$scripts_loaded ) ) {
            self::$scripts_loaded[] = $script_src;

            return '<script' . ( $tag_id != '' ? ' id="' . $tag_id . '"' : '' ) . ' type="text/javascript" src="' . $script_src . '"></script>';
        }

        return '';

    }

}