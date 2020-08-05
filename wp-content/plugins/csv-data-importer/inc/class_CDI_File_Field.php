<?php 
class CDI_File_Field{

  private $csv_file_type = 'text/csv';

  public function get_file_field(){
    return $_FILES['cdi-csv-file'];
  }
  
  public function get_file_temp_name(){
    $file_field = $this->get_file_field();
    return $file_field["tmp_name"];
  }

  public function is_csv_file(){
    return $this->get_file_type() === $this->csv_file_type;
  }

  public function get_file_type(){
    $file_field = $this->get_file_field();
    return $file_field["type"];
  }

  public function is_uploading_failed(){    
    return $this->get_file_error_code() > 0;
  }

  public function get_file_error_code(){
    $file_field = $this->get_file_field();
    return $file_field["error"];
  }

  public function has_file(){
    $file_field = $this->get_file_field();
    return isset($file_field);
  } 

}