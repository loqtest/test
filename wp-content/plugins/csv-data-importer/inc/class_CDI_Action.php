<?php 

class CDI_Action{
  public function __construct() {    
    add_action( 'wp_ajax_cdi_acf_group_action', array($this, 'cdi_acf_group_action' ) );
  } 

  public function cdi_acf_group_action() {
    $post_type = $_POST['post_type'];

    $cdi_acf = new CDI_ACF();

    echo json_encode($cdi_acf->get_fields_by_post_type($post_type));

    wp_die(); 
  }
}

new CDI_Action();