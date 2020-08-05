<?php
/**
 * @package CSV Data Importer
 * @version 1.0.0
 */
/*
Plugin Name: CSV Data Importer
Plugin URI: https://thewoo.com/
Description: Imports CSV data into the selected post type & ACF fields.
Author: Lougie Quisel
Version: 1.0.0
Author URI: https://thewoo.com/
Text Domain: csv-data-importer
*/

# Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'CDI_TEXT_DOMAIN', 'csv-data-importer' );
define( 'CDI_PATH', dirname( __FILE__ ) );
define( 'CDI_DIR', basename( CDI_PATH ));
define( 'CDI_URL', plugins_url() . '/' . CDI_DIR );
define( 'CDI_FILE', plugin_basename( __FILE__ ) );

require_once(CDI_PATH . "/inc/class_CDI_ACF.php");
require_once(CDI_PATH . "/inc/class_CDI_File_Field.php");
require_once(CDI_PATH . "/inc/class_CDI_Action.php");
require_once(CDI_PATH . "/inc/class_CDI_Importer.php");

final class Initialise_CDI {

  use Form_Helper;

  private $admin_hook_suffix = 'settings_page_csv_data_importer';

  public function __construct() {
    add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts' ));
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
  }

  public function enqueue_scripts($hook_suffix) {
    if($this->isPluginPage($hook_suffix)){
      wp_enqueue_style( 'cdi_style', CDI_URL . '/assets/css/csv-data-importer.css' );
      wp_enqueue_script( 'cdi_js', CDI_URL . '/assets/js/csv-data-importer.js', array(), false, true );
    }
  }

  public function admin_menu() {
    add_options_page(
        __( 'CSV Data Importer', CDI_TEXT_DOMAIN ),
        __( 'CSV Data Importer', CDI_TEXT_DOMAIN ),
        'manage_options',
        'csv_data_importer',
        array(
            $this,
            'settings_page'
        )
    );
  }

  public function settings_page() {
    $post_types = $this->get_custom_post_types();
    $cdi_importer = new CDI_Importer();
    $cdi_importer->process_importing();

    include_once(CDI_PATH . "/templates/uploader-form.php");
  }

  private function isPluginPage($hook_suffix){
    return $hook_suffix === $this->getAdminHookSuffix();
  }

  private function getAdminHookSuffix(){
    return $this->admin_hook_suffix;
  }

}

trait Form_Helper{

  public function get_custom_post_types(){
    $args = array(
      'public'   => true,
      '_builtin' => false
   );

   $output = 'names';
   $operator = 'and';

   return get_post_types( $args, $output, $operator );
  }

}

new Initialise_CDI();