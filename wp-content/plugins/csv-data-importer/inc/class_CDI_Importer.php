<?php
class CDI_Importer{

  protected $cdi_acf;

  public function __construct(){
    $this->cdi_acf = new CDI_ACF();
  }

  public function get_cdi_acf_instance(){
    return $this->cdi_acf;
  }

  public function process_importing(){
    if ( isset($_POST["cdi-submit-btn"]) ) {
      $post_type = $_POST['cdi-post-type'];
      $cdi_field = $_POST['cdi-field'];

      $cdi_file_field = new CDI_File_Field();
      $cdi_acf = $this->get_cdi_acf_instance();

      if ( $cdi_file_field->has_file() && !$cdi_file_field->is_uploading_failed() && $cdi_file_field->is_csv_file()) {

        $csv_array = $this->convert_csv_data_to_array($cdi_file_field->get_file_temp_name());

        foreach($csv_array as $key => $csv_row){
          if($key === 0) continue; //skip csv headings

          $new_post_id = null;

          foreach($cdi_field as $key2 => $field){
            if($new_post_id){
              $csv_column_value = $this->get_csv_column_value($csv_row, $field);
              $acf_field_key = $this->get_acf_field_key($key2, $post_type);
              $cdi_acf->addACFField($acf_field_key, $csv_column_value, $new_post_id);
            }

            if($key2 === 0){
              $post_title = $this->get_csv_column_value($csv_row, $field);
              $new_post_id = $this->add_new_post($post_type, $post_title);
            }

          }

        }

        $this->show_success_message();
      }
      else{
        $this->show_error_message();
      }

    }
  }

  public function convert_csv_data_to_array($file_name){
    return array_map('str_getcsv', file($file_name));
  }

  public function show_success_message(){
    echo "<p class='cdi-msg cdi-msg--success'>CSV Data successfully imported!</p>";
  }

  public function show_error_message(){
    echo "<p class='cdi-msg cdi-msg--error'>Error found. Please check your file.</p>";
  }

  public function get_csv_column_value($csv_row, $field, $index_difference = 1){
    return $csv_row[$field - $index_difference];
  }

  public function get_acf_field_key($field, $post_type, $index_difference = 1){
    $cdi_acf = $this->get_cdi_acf_instance();
    $acf_fields = $cdi_acf->get_fields_by_post_type($post_type);
    $acf_field = $acf_fields[$field - $index_difference];
    return $acf_field['key'];
  }

  public function add_new_post($post_type, $post_title){
    return wp_insert_post(['post_title' => $post_title, 'post_type' => $post_type, 'post_status' => 'publish']);
  }

}