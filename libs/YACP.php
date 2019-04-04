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
    }

    public function init()
    {
        new \YACP\YacpPostType();
    }

    protected function load_assets()
    {
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('wp_footer', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts()
    {
        wp_register_script('yacp_js', plugin_dir_url(__DIR__) . '/assets/dist/yacp.front.js', false, '');
        wp_enqueue_script('yacp_js');
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

    public function yacp_shortcode($params)
    {
        $params = shortcode_atts(array(
            'id' => null,
        ), $params);

        $cd = get_post($params['id']);

        if (!empty($cd) && !empty($cd->post_type) && $cd->post_type === 'yacp_post') {
            $cd->yacp_date = get_post_meta($cd->ID, "_yacp_date", true);
            $cd->yacp_utc = get_post_meta($cd->ID, "_yacp_utc", true);
            $cd->yacp_theme = get_post_meta($cd->ID, "_yacp_theme", true);

            $cd_start = '<script>';
            $cd_code = "
            function startYACP() {
                simplyCountdown('.yacp-" . $params['id'] . "', {
                    year: 2019, // required
                    month: 6, // required
                    day: 28, // required
                    hours: 0, // Default is 0 [0-23] integer
                    minutes: 0, // Default is 0 [0-59] integer
                    seconds: 0, // Default is 0 [0-59] integer
                    words: { //words displayed into the countdown
                        days: 'day',
                        hours: 'hour',
                        minutes: 'minute',
                        seconds: 'second',
                        pluralLetter: 's'
                    },
                    plural: true, //use plurals
                    inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
                    inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
                    // in case of inline set to false
                    enableUtc: true,
                    onEnd: function () {
                        // your code
                        return;
                    },
                    refresh: 1000, //default refresh every 1s
                    sectionClass: 'simply-section', //section css class
                    amountClass: 'simply-amount', // amount css class
                    wordClass: 'simply-word', // word css class
                    zeroPad: false
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

            $cd_full = $cd_start . $cd_code .$cd_end_tag;

            return '<div class="yacp-' . $params['id'] . '"></div>' . $cd_full;

            //return '<strong>Must display the countdown registered date : ' . $cd->yacp_date . ' with UTC set to "' . $cd->yacp_utc . '" Theme choosen is : ' . $cd->yacp_theme . '</strong>';
        } else {
            return "fail";
        }

    }
}