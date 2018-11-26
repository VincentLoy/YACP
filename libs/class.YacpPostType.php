<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 11/26/18
 * Time: 2:45 PM
 */

namespace YACP;

/**
 * The Core of this custom post type was generated thanks to the CPT UI plugin. Then He was
 * Customized.
 * Class YacpPostType
 * @package YACP
 */
class YacpPostType
{
    function __construct()
    {
        $this->custom_post_slug = 'yacp_post';

        $this->labels = array(
            "name" => __("YACP Countdowns", "twentyfifteen"),
            "singular_name" => __("YACP Countdown", "twentyfifteen"),
        );

        $this->args = array(
            "label" => __("YACP Countdowns", "twentyfifteen"),
            "labels" => $this->labels,
            "description" => "",
            "public" => false,
            "publicly_queryable" => false,
            "show_ui" => true,
            "delete_with_user" => false,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "exclude_from_search" => true,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => false,
            "query_var" => false,
            "supports" => array("title",),
        );

        $this->available_themes = array(
            'default' => __('Default Theme', 'yacp_textdomain'),
            'losange' => __('Losange Theme', 'yacp_textdomain')
        );

        $this->custom_fields = array(
            'theme' => array(
                'name' => __('Theme', 'yacp_textdomain'),
                'key' => '_yacp_theme'
            )
        );

        add_action('init', array($this, 'register_my_cpts_yacp_post'));
        add_action('add_meta_boxes', array($this, 'custom_meta_boxes'));
        add_action('save_post', array($this, 'yacp_save_meta_box_data'));
    }


    function custom_meta_boxes()
    {
        add_meta_box(
            'yacp_countdown',
            __('YACP Countdown Settings', 'yacp_textdomain'),
            array($this, 'yacp_add_theme_field'),
            $this->custom_post_slug
        );
    }

    function yacp_add_theme_field($post)
    {

        // Add a nonce field so we can check for it later.
        wp_nonce_field('yacp_save_meta_box_data', 'yacp_meta_box_nonce');

        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        $theme = get_post_meta($post->ID, $this->custom_fields['theme']['key'], true);

        include 'admin/tpl.yacp_custom_field.php';
    }

    function yacp_save_meta_box_data($post_id)
    {

        if (!isset($_POST['yacp_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['yacp_meta_box_nonce'], 'yacp_save_meta_box_data')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (isset($_POST['post_type']) && $this->custom_post_slug == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        if (!isset($_POST['yacp_theme'])) {
            return;
        }

        $theme = sanitize_text_field($_POST['yacp_theme']);

        update_post_meta($post_id, $this->custom_fields['theme']['key'], $theme);
    }

    /**
     *
     */
    function register_my_cpts_yacp_post()
    {
        /**
         * Post Type: YACP Countdowns.
         */
        register_post_type($this->custom_post_slug, $this->args);
    }
}