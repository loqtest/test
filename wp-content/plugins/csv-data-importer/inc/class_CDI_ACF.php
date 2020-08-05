<?php 
class CDI_ACF{

  public function get_post_type_acf_group_key($post_type) {
    $groups = acf_get_field_groups(array('post_type' => $post_type));
    return count($groups) > 0 ? $groups[0]['key'] : null;
  }

  public function get_fields($key){
    return acf_get_fields($key);
  }

  public function get_fields_by_post_type($post_type){
    $key = $this->get_post_type_acf_group_key($post_type);    
    return $key ? $this->get_fields($key) : 0;
  }

  public function addACFField($key, $value, $new_post_id){
    update_field($key, $value, $new_post_id);
  }

}