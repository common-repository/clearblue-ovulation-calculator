<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('CbOvulationCalculator_Admin')) :

class CbOvulationCalculator_Admin {

    public static $languages = array(
      'en_UK' => 'English',
      'fr_FR' => 'Français',
      'es_ES' => 'Español',
      'br_BR' => 'Brasileiro',
      'cn_CN' => '中文',
      'de_DE' => 'Deutsche',
      'fi_FI' => 'Suomalainen',
      'it_IT' => 'Italiano',
      'kr_KR' => '한국어',
      'nl_NL' => 'Nederlands',
      'pl_PL' => 'Polskie',
      'ru_RU' => 'Pусский',
      'no_NO' => 'Norsk',
      'se_SE' => 'Svenska'
    );

    public static $colors = array(
        'background' => '#FFFFFF',
        'title' => '#00457C',
        'text' => '#222222',
        'button' => '#00457C',
        'button-text' => '#FFFFFF',
        'input' => '#FFFFFF',
        'border' => '#EBEBEB',
        'error' => '#DC3545',
        'bubble-period' => '#CF1D64',
        'bubble-prct-0-5' => '#A196CD',
        'bubble-prct-10-15' => '#796EA5',
        'bubble-prct-20' => '#60519B'
    );

    public static $formats = array(
        'square',
        'round'
    );

    public static $options = array();

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
        add_action('admin_menu', 'CbOvulationCalculator_Admin::admin_menu');
        add_action('admin_enqueue_scripts', 'CbOvulationCalculator_Admin::load_assets');

        self::update_options();
        self::$options = self::get_options();
    }

    /*
    *  admin_menu
    *
    *  @type    static
    *  @date    2020-02-05
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  N/A
    */

    public static function admin_menu() {
        add_submenu_page(
            'tools.php',
            CbOvulationCalculator_Data::__(CBOC_NAME),
            CbOvulationCalculator_Data::__(CBOC_NAME),
            'manage_options',
            CBOC_BASENAME,
            'CbOvulationCalculator_Admin::admin'
        );
    }

    /*
    *  admin
    *
    *  @type    static
    *  @date    2020-02-05
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  N/A
    */

    public static function admin() {
        require dirname(__FILE__) . '/../inc/admin.php';
    }

    /*
    *  get_options
    *
    *  @type    static
    *  @date    2020-02-05
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  $options
    */

    public static function get_options() {
        $options = array(
            'language' => get_option('cboc-language', 'en_UK'),
            'format' => get_option('cboc-format', 'square'),
            'show-credits' => !!get_option('cboc-show-credits', 0),
            'colors' => array()
        );

        foreach (CbOvulationCalculator_Admin::$colors as $key => $default) {
            $options['colors'][$key] = get_option('cboc-color-' . $key, $default);
        }

        return $options;
    }

    /*
    *  update_options
    *
    *  @type    static
    *  @date    2020-02-05
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  N/A
    */

    public static function update_options() {
        if (isset($_POST['cboc-submit'])) {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'cboc-') === 0) {
                    $safe_value = sanitize_text_field($value);
                    update_option($key, $safe_value);
                }
            }

            if (!isset($_POST['cboc-show-credits'])) {
                update_option('cboc-show-credits', 0);
            }
        } elseif (isset($_POST['cb-submit-reset'])) {
            if (isset($_POST['cboc-reset'])) {
                self::reset_options();
            }
        }
    }

    /*
    *  reset_options
    *
    *  @type    static
    *  @date    2020-02-05
    *  @since   1.0
    *
    *  @param   N/A
    *  @return  N/A
    */

    public static function reset_options() {
        update_option('cboc-language', array_keys(self::$languages)[0]);
        update_option('cboc-format', self::$formats[array_keys(self::$formats)[0]]);
        update_option('cboc-show-credits', 0);

        foreach (self::$colors as $key => $color) {
            update_option('cboc-color-' . $key, $color);
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
            'spectrum',
            CBOC_PLUGIN_URL . 'assets/css/vendor/spectrum.css',
            array(),
            '2.0.0'
        );

        wp_enqueue_style(
            CBOC_BASENAME,
            CBOC_PLUGIN_URL . 'assets/css/' . CBOC_BASENAME . '-admin.css',
            array(),
            CBOC_VERSION
        );

        wp_enqueue_script(
            'spectrum',
            CBOC_PLUGIN_URL . 'assets/js/vendor/spectrum.min.js',
            array('jquery'),
            '2.0.0',
            true
        );

        wp_enqueue_script(
            CBOC_BASENAME,
            CBOC_PLUGIN_URL . 'assets/js/' . CBOC_BASENAME . '-admin.js',
            array('jquery'),
            CBOC_VERSION,
            true
        );
    }

}

endif;
