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

    /**
     * This is where all needed vars are instancied.
     * Some needed actions are listed here too
     * YacpPostType constructor.
     */
    function __construct()
    {
        $this->custom_post_slug = 'yacp_post';

        $this->labels = array(
            "name" => __("YACP Countdowns", "yacp_textdomain"),
            "singular_name" => __("YACP Countdown", "yacp_textdomain"),
        );

        $this->args = array(
            "label" => __("YACP Countdowns", "yacp_textdomain"),
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
            "supports" => array("title", "posts-formats"),
            "menu_icon" => "dashicons-clock",
        );

        $this->available_themes = array(
            'default' => __('Default Theme', 'yacp_textdomain'),
            'losange' => __('Losange Theme', 'yacp_textdomain')
        );

        $this->custom_fields = array(
            'theme' => array(
                'name' => __('Theme', 'yacp_textdomain'),
                'key' => '_yacp_theme'
            ),
            'date' => array(
                'name' => __('Date', 'yacp_textdomain'),
                'key' => '_yacp_date'
            ),
            'utc' => array(
                'name' => __('UTC Date', 'yacp_textdomain'),
                'key' => '_yacp_utc'
            ),
        );

        add_action('init', array($this, 'register_my_cpts_yacp_post'));
        add_action('add_meta_boxes', array($this, 'custom_meta_boxes'));
        add_action('save_post', array($this, 'yacp_save_meta_box_data'));
    }

    /**
     * Check if we are in EDIT page or NEW POST page
     * @param string $new_edit
     * @return bool
     */
    protected function is_edit_page($new_edit = 'edit')
    {
        global $pagenow;

        if ($new_edit == 'edit')
            return in_array($pagenow, array('post.php',));
        elseif ($new_edit == "new") //check for new post page
            return in_array($pagenow, array('post-new.php'));
        else //check for either new or edit
            return in_array($pagenow, array('post.php', 'post-new.php'));
    }

    /**
     * Create the context for admin meta boxes view
     * @param $post
     * @return array
     */
    protected function get_template_context($post)
    {
        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        return array(
            'ID' => $post->ID,
            'theme' => get_post_meta($post->ID, $this->custom_fields['theme']['key'], true),
            'date' => get_post_meta($post->ID, $this->custom_fields['date']['key'], true),
            'utc' => get_post_meta($post->ID, $this->custom_fields['utc']['key'], true),
        );
    }

    /**
     * Generate the heart <3 of the shortcode
     * @param $center
     * @param $key
     * @param $value
     * @return string
     */
    protected function populate_shortcode($center, $key, $value)
    {
        return ' ' . $center . $key . '="' . $value . '"';
    }

    /**
     * Create the preview shortcode to allow user to copy/paste it
     * @param $post
     * @return string
     */
    protected function get_shortcode_preview($post)
    {
        $sc_start = '[yacp';
        $sc_center = '';
        $sc_end = ']';

        if ($this->is_edit_page()) {
            $sc_center = $this->populate_shortcode($sc_center, 'id', $post->ID);
            return $sc_start . $sc_center . $sc_end;
        }

        return __(
            'The Shortcode preview will be displayed here after post is saved',
            'yacp_textdomain'
        );
    }


    /**
     * Add the YACP meta box
     */
    public function custom_meta_boxes()
    {

        add_meta_box(
            'yacp_shortcode_preview_box',
            __('Maméno', 'yacp_textdomain'),
            array($this, 'yacp_add_shortcode_preview'),
            $this->custom_post_slug,
            'normal',
            'low'
        );

        add_meta_box(
            'yacp_countdown',
            __('YACP Countdown Settings', 'yacp_textdomain'),
            array($this, 'yacp_add_theme_fields'),
            $this->custom_post_slug,
            'normal',
            'high'
        );

        add_meta_box(
            'yacp_donation_box',
            __('Make a donation <3', 'yacp_textdomain'),
            array($this, 'yacp_donation'),
            $this->custom_post_slug,
            'side',
            'core'
        );

        add_meta_box(
            'yacp_last_box',
            __('test', 'yacp_textdomain'),
            array($this, 'yacp_last_box'),
            $this->custom_post_slug,
            'advanced',
            'low'
        );
    }

    public function yacp_last_box($post)
    {
        echo '<div class="blob">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam magni neque possimus ullam. Eveniet, mollitia neque nisi numquam rem ullam?</div>';
    }

    public function yacp_donation($post)
    {
        echo '<img src="https://via.placeholder.com/255x305"/>';
    }

    public function yacp_add_shortcode_preview($post)
    {
        $shortcode = $this->get_shortcode_preview($post);
        include 'admin/tpl.yacp_shortcode_preview.php';
    }

    /**
     * Callback of the add_meta_box above
     * This is where the form template is built
     * @param $post
     */
    public function yacp_add_theme_fields($post)
    {

        // Add a nonce field so we can check for it later.
        wp_nonce_field('yacp_save_meta_box_data', 'yacp_meta_box_nonce');

        $ctx = $this->get_template_context($post);
        include 'admin/tpl.yacp_custom_field.php';
    }

    /**
     * Save the custom meta tags for YACP post type
     * @param $post_id
     */
    public function yacp_save_meta_box_data($post_id)
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

        if (!isset($_POST['yacp_theme']) || !isset($_POST['yacp_date'])) {
            return;
        }

        $theme = sanitize_text_field($_POST['yacp_theme']);
        $date = $_POST['yacp_date'];
        $utc = $_POST['yacp_utc'];

//        var_dump($_POST);
        echo $theme;
        echo $date;
        echo $utc;
//        exit();

        update_post_meta($post_id, $this->custom_fields['theme']['key'], $theme);
        update_post_meta($post_id, $this->custom_fields['date']['key'], $date);
        update_post_meta($post_id, $this->custom_fields['utc']['key'], $utc);
    }

    /**
     * Simply Register the YACP Custom Post Type
     */
    public function register_my_cpts_yacp_post()
    {
        /**
         * Post Type: YACP Countdowns.
         */
        register_post_type($this->custom_post_slug, $this->args);
    }
}