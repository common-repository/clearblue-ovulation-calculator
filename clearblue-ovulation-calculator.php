<?php
/**
 * Plugin Name: Clearblue® Ovulation Calculator
 * Plugin URI: 
 * Description: An ovulation calculator estimates how likely a woman is to release an egg on a particular day in her menstrual cycle.
 * Version: 1.2.4
 * Author: Agence Kali
 * Author URI: http://www.agencekali.fr/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: clearblue-ovulation-calculator
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('CbOvulationCalculator')) :

define('CBOC_PLUGIN_URL',   plugin_dir_url(__FILE__));
define('CBOC_BASENAME',     'clearblue-ovulation-calculator');
define('CBOC_NAME',         'Ovulation Calculator');
define('CBOC_VERSION',      '1.2.4');

require dirname(__FILE__) . '/class/plugin.php';
require dirname(__FILE__) . '/class/admin.php';
require dirname(__FILE__) . '/class/widget.php';
require dirname(__FILE__) . '/class/shortcode.php';
require dirname(__FILE__) . '/class/data.php';

new CbOvulationCalculator();

endif;
