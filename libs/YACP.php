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

            return '<strong>Must display the countdown registered date : ' . $cd->yacp_date . ' with UTC set to "' . $cd->yacp_utc . '" Theme choosen is : ' . $cd->yacp_theme . '</strong>';
        } else {
            return "fail";
        }

    }
}