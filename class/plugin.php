<?php

if (!defined('ABSPATH')) exit;

class CbOvulationCalculator {

    /*
    *  __construct
    *
    *  @type    function
    *  @date    2020-02-05
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  N/A
    */

    function __construct() {
        new CbOvulationCalculator_Admin();
        new CbOvulationCalculator_Data();
        new CbOvulationCalculator_Widget();
        new CbOvulationCalculator_Shortcode();

        add_action('wp_enqueue_scripts', 'CbOvulationCalculator::load_assets');
        add_action('wp_head', 'CbOvulationCalculator::add_inline_style', 100);

        // on update, always check the credits
        if (get_option('cbddc-version') != CBDDC_VERSION) {
            update_option('cbddc-show-credits', 1);
            update_option('cbddc-version', CBDDC_VERSION);
        }
    }


    /*
    *  load_assets
    *
    *  @type    static
    *  @date    2020-02-05
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  N/A
    */

    public static function load_assets() {
        wp_enqueue_style(
            'air-datepicker',
            CBOC_PLUGIN_URL . 'assets/css/vendor/datepicker.min.css',
            array(),
            '2.2.3'
        );

        wp_enqueue_style(
            CBOC_BASENAME,
            CBOC_PLUGIN_URL . 'assets/css/' . CBOC_BASENAME . '.css',
            array(),
            CBOC_VERSION
        );

        wp_enqueue_script(
            'air-datepicker',
            CBOC_PLUGIN_URL . 'assets/js/vendor/datepicker.min.js',
            array('jquery'),
            '2.2.3',
            true
        );

        wp_enqueue_script(
            'clearblue-ovulation-datepicker',
            CBOC_PLUGIN_URL . 'assets/js/clearblue-datepicker.js',
            array('jquery'),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            CBOC_BASENAME,
            CBOC_PLUGIN_URL . 'assets/js/' . CBOC_BASENAME . '.js',
            array('jquery'),
            CBOC_VERSION,
            true
        );
    }

    /*
    *  add_inline_style
    *
    *  @type    static
    *  @date    2020-02-11
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  N/A
    */

    public static function add_inline_style() {
        $styles = '<style>';
        $styles .= ':root {';

        foreach (CbOvulationCalculator_Admin::$options['colors'] as $key => $value) {
            $styles .= '--cboc-color-' . $key . ': ' . $value . ';';
        }

        $styles .= '}';
        $styles .= '</style>';

        echo $styles;
    }

}
