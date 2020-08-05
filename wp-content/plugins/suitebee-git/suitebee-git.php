<?php
/**
 * @package Suitebee Git
 * @version 1.0
 */
/*
/*
Plugin Name: Suitebee Git
Plugin URI: https://thewoo.com/
Description: Integrates Git in specified directory
Version: 1.0
Author: Lougie Quisel
Author URI: https://lougiequisel.com/
Text Domain: suitebee-git
*/


# Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'SG_VERSION', '0.1' );
define( 'SG_TEXT_DOMAIN', 'suitebee-git' );
define( 'SG_PATH', dirname( __FILE__ ) );
define( 'SG_DIR', basename( SG_PATH ));
define( 'SG_URL', plugins_url() . '/' . SG_DIR );


require_once(SG_PATH . "/inc/class__SG_Settings.php");
require_once(SG_PATH . "/inc/class__SG_Files.php");