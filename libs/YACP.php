<?php

/**
 * Author: Vincent Loy <vincent.loy1@gmail.com>
 * Date: 11/26/18
 * Time: 2:44 PM
 */

namespace YACP;

include "class.YacpPostType.php";

/**
 * This is the base class, all the code init start from here
 * =========================================================
 * Class YACP
 * @package YACP
 */
class YACP
{
    public function __construct()
    {
        $this->init();
        $this->load_assets();
        $this->load_shortcode();

        // See var available_themes in class.YacpPostType.php, they must be sync
        $this->themes = array(
            'default' => array(
                'class' => 'simply-countdown',
            ),
            'losange' => array(
                'class' => 'simply-countdown-losange',
            ),
            'inline' => array(
                'class' => 'simply-countdown-inline',
            ),
            'simple-white' => array(
                'class' => 'simply-countdown-simple-white',
                'css' => '/assets/dist/themes/yacp-simple-white.css',
            ),
            'simple-black' => array(
                'class' => 'simply-countdown-simple-black',
                'css' => '/assets/dist/themes/yacp-simple-black.css',
            ),
            'custom' => array(
                'class' => 'simply-countdown-custom',
            ),
        );

        $this->selected_theme = null;
    }

    public function init()
    {
        new \YACP\YacpPostType();
    }

    protected function load_assets()
    {
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('wp_footer', array($this, 'enqueue_scripts_and_styles'));
    }

    public function enqueue_scripts_and_styles()
    {
        wp_register_script('yacp_js', plugin_dir_url(__DIR__) . '/assets/dist/yacp.front.js', false, '');
        wp_enqueue_script('yacp_js');

        wp_register_style('yacp_css', plugin_dir_url(__DIR__) . '/assets/dist/yacp_frontend.css', false, '');
        wp_enqueue_style('yacp_css');
    }

    /**
     * Load a CSS file that contain que YACP custom theme for countdown
     * Make sure $this->selected_theme is set before
     */
    public function enqueue_yacp_custom_theme()
    {
        if (!empty($this->selected_theme)) {
            $name = 'yacp_custom_theme--' . $this->selected_theme['class'];
            wp_register_style($name, plugin_dir_url(__DIR__) . $this->selected_theme['css'], false, '');
            wp_enqueue_style($name);
        }
    }

    public function admin_enqueue_styles()
    {
        wp_register_style('yacp_admin_css', plugin_dir_url(__DIR__) . '/assets/dist/yacp_backend.css', false, '');
        wp_enqueue_style('yacp_admin_css');
    }

    public function admin_enqueue_scripts()
    {
        wp_register_script('yacp_admin_js', plugin_dir_url(__DIR__) . '/assets/dist/yacp.backend.js', false, '');
        wp_enqueue_script('yacp_admin_js');
    }

    public function load_shortcode()
    {
        add_shortcode('yacp', array($this, 'yacp_shortcode'));
    }

    protected function generate_javascript($cd, $uid) 
    {
        $cd_start_tag = '<script>';
        $cd_code = "
            function startYACP() {
                simplyCountdown('#yacp-" . $uid . "', {
                    year: " . $cd->yacp_date->format('Y') . ",
                    month: " . $cd->yacp_date->format('m') . ",
                    day: " . $cd->yacp_date->format('d') . ",
                    hours: " . $cd->yacp_date->format('H') . ",
                    minutes: " . $cd->yacp_date->format('i') . ",
                    seconds: 0,
                    words: { //words displayed into the countdown
                        days: '" . $cd->wording_day . "',
                        hours: '" . $cd->wording_hour . "',
                        minutes: '" . $cd->wording_minute . "',
                        seconds: '" . $cd->wording_second . "',
                        pluralLetter: '" . $cd->wording_plural_letter . "'
                    },
                    plural: true, //use plurals
                    inline: " . $cd->is_inline . ",
                    inlineClass: 'simply-countdown-inline',
                    // in case of inline set to false
                    enableUtc: " . $cd->yacp_utc . ",
                    onEnd: function () {
                        // your code
                        return;
                    },
                    refresh: 1000, //default refresh every 1s
                    sectionClass: 'simply-section', //section css class
                    amountClass: 'simply-amount', // amount css class
                    wordClass: 'simply-word', // word css class
                    zeroPad: " . $cd->yacp_zero_pad . "
                });
            };

            function ready(fn) {
                if (document.attachEvent ? document.readyState === 'complete' : document.readyState !== 'loading'){
                    fn();
                } else {
                    document.addEventListener('DOMContentLoaded', fn);
                }
            }

            ready(startYACP);
            ";
        $cd_end_tag = '</script>';

        return $cd_start_tag . $cd_code .$cd_end_tag;
    }

    public function yacp_shortcode($params)
    {
        $params = shortcode_atts(array(
            'id' => null,
        ), $params);

        $cd = get_post($params['id']);

        if (!empty($cd) && !empty($cd->post_type) && $cd->post_type === 'yacp_post') {
            $uid = md5(uniqid(rand(), true));
            $cd->yacp_date = date_create_from_format(
                'Y-m-d H:i',
                get_post_meta($cd->ID, "_yacp_date", true)
            );
            $cd->yacp_utc = !empty(get_post_meta($cd->ID, "_yacp_utc", true)) ? 1 : 0;
            $cd->yacp_zero_pad = !empty(get_post_meta($cd->ID, "_yacp_zero_pad", true)) ? 1 : 0;
            $cd->yacp_theme = get_post_meta($cd->ID, "_yacp_theme", true);
            $cd->is_inline = ($cd->yacp_theme == 'inline') ? 1 : 0;
            $this->selected_theme = $this->themes[$cd->yacp_theme];

            $cd->wording_day = (!empty(get_post_meta($cd->ID, "_yacp_days", true))) ? get_post_meta($cd->ID, "_yacp_days", true) : 'day';
            $cd->wording_hour = (!empty(get_post_meta($cd->ID, "_yacp_hours", true))) ? get_post_meta($cd->ID, "_yacp_hours", true) : 'hour';
            $cd->wording_minute = (!empty(get_post_meta($cd->ID, "_yacp_minutes", true))) ? get_post_meta($cd->ID, "_yacp_minutes", true) : 'minute';
            $cd->wording_second = (!empty(get_post_meta($cd->ID, "_yacp_seconds", true))) ? get_post_meta($cd->ID, "_yacp_seconds", true) : 'second';
            $cd->wording_plural_letter = (!empty(get_post_meta($cd->ID, "_yacp_plural_letter", true))) ? get_post_meta($cd->ID, "_yacp_plural_letter", true) : 's';

            if (array_key_exists('css', $this->themes[$cd->yacp_theme])) {
                //enqueue_yacp_custom_theme
                add_action('wp_footer', array($this, 'enqueue_yacp_custom_theme'));
            }

            return '<div id="yacp-' . $uid . '" class="' . $this->selected_theme['class'] . '"></div>' . $this->generate_javascript($cd, $uid);
        } else {

            return "Can't display the countdown...";
        }

    }
}