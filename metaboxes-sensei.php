<?php
/**
 * Plugin Name: Metaboxes Sensei
 * Plugin URI: https://servicios.ayudawp.com/
 * Description: Show videos and attachments from metaboxes with Sensei LMS Learning Mode active. 
 * Version: 1.3
 * Author: Fernando Tellado
 * Author URI: https://ayudawp.com
 *
 * @package Metaboxes Sensei
 * License: GPL2+
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: metaboxes-sensei
 *
 * METABOXES SENSEI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * METABOXES SENSEI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with METABOXES SENSEI. If not, see https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/* INIT FOR TRANSLATION READY */
function metaboxes_sensei_init() {
	load_plugin_textdomain( 'metaboxes-sensei', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'metaboxes_sensei_init' );

/* PLUGIN FUNCTIONS - https://ayudawp.com/problemas-modo-aprendizaje-sensei/ */

/* Show attachments from metaboxes with Sensei LMS Learning Mode active */
function metasensei_attachment_lessons( $content ) {
    if ( ! class_exists('Sensei_Media_Attachments') || is_admin() || ! is_single() || 'lesson' !== get_post_type() || ! Sensei_Course_Theme_Option::instance()->should_use_sensei_theme() ) {
    return $content;
    }
    remove_filter( 'the_content', 'metasensei_attachment_lessons', 80 );
    ob_start();
    Sensei_Media_Attachments::instance()->display_attached_media();
    $media = ob_get_clean();
    return $content . $media;
    }
    add_filter( 'the_content', 'metasensei_attachment_lessons', 80, 1 );