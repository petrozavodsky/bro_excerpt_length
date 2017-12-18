<?php
/*
Plugin Name: Bro Excerpt Length
Plugin URI: https://github.com/petrozavodsky/bro_excerpt_length
Description: Excerpt adds the ability to limit the number of characters on the client-side.
Author: Vovasik ,Petrozavodsky
Author URI: https://alkoweb.ru/
Version: 1.0.1
Text Domain: bro_excerpt_length
*/

if (!defined('ABSPATH')) exit;

class Bro_Excerpt_Length
{
    private $version = '1.0.1';
    private $field_option = 'default_bro_excerpt_length';

    public function __construct()
    {
        add_action('admin_footer', array($this, 'add_js_css'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        $this->load_dependency();

    }

    public function load_dependency()
    {
        require_once 'admin/options.php';
    }

    public function load_textdomain()
    {
        $mo_file_path = plugin_dir_path(__FILE__) . 'lang/bro_excerpt_length-' . get_locale() . '.mo';
        load_textdomain('bro_excerpt_length', $mo_file_path);
    }

    public function current_screen()
    {
        global $post;
        $screen = get_current_screen();
        if ($screen->parent_base = 'edit') {
            return apply_filters('bro_excerpt_length_add', true, $screen , $post);
        }

        return apply_filters('bro_excerpt_length_add', false, $screen, $post);
    }

    public function add_js_css()
    {
        if ($this->current_screen()) {
            wp_enqueue_script(
                'bro_excerpt_length_js',
                plugin_dir_url(__FILE__) . 'public/js/counter.min.js',
                array('jquery'),
                $this->version,
                true
            );

            wp_localize_script(
                'bro_excerpt_length_js',
                'bro_excerpt_length_js_localize',
                array(
                    'string_more' => __('Characters left: ', 'bro_excerpt_length'),
                    'string_less' => __('Limit exceeded by: ', 'bro_excerpt_length')
                )
            );

            wp_localize_script(
                'bro_excerpt_length_js',
                'bro_excerpt_length_js_variable',
                array(
                    'count' => get_option($this->field_option, apply_filters('excerpt_length', 140)),
                )
            );

            wp_enqueue_style(
                'bro_excerpt_length_js',
                plugin_dir_url(__FILE__) . 'public/css/style-highlight.css',
                array(),
                $this->version,
                'all'
            );

        }
    }

}

function Bro_Excerpt_Length_Init()
{
    new Bro_Excerpt_Length();
}

add_action('plugins_loaded', 'Bro_Excerpt_Length_Init', 20);