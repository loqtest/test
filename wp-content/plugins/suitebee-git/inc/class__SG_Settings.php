<?php
class SG_Settings{

  private $admin_hook_suffix = 'settings_page_suitebee_git';

  public function __construct() {
    add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts' ));
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
  }

  public function enqueue_scripts($hook_suffix) {
    if($this->is_plugin_page($hook_suffix)){
      wp_enqueue_style( 'sg-style', SG_URL . '/assets/css/sg-settings.css' );
    }
  }

  public function admin_menu() {
    add_options_page(
        __( 'Suitebee Git', SG_TEXT_DOMAIN ),
        __( 'Suitebee Git', SG_TEXT_DOMAIN ),
        'manage_options',
        'suitebee_git',
        array(
            $this,
            'settings_page'
        )
    );
  }

  public function settings_page() {
    if ( isset($_POST["sg-submit-btn"]) ) {
      $username = $_POST['usernane'];
      $password = $_POST['password'];
      $repo = $_POST['repo'];
      $directory = $_POST['directory'];

      $this->save($username, $password, $repo, $directory);
      SG_Files::generate_sh_file($username, $password, $repo, $directory);
      SG_Files::generate_git_ignore_file($directory);
      $this->show_message('SH file successfully generated!');
    }
    include_once(SG_PATH . "/views/settings.php");


    $directory = get_option('sg_directory');
    if ( isset($_POST["sg-execute-btn"]) ) {
      $execute_status = SG_Files::execute_sh_file($directory);
      $this->show_message($execute_status);
    }
    if($directory){
      include_once(SG_PATH . "/views/execute-form.php");
    }
  }

  private function show_message($msg){
    echo "<p class='sg-msg sg-msg--success'>$msg</p>";
  }


  private function save($username, $password, $repo, $directory) {
      update_option('sg_username', $username);
      update_option('sg_password', $password);
      update_option('sg_repo', $repo);
      update_option('sg_directory', $directory);
  }

  private function is_plugin_page($hook_suffix) {
    return $hook_suffix === $this->get_admin_hook_suffix();
  }

  private function get_admin_hook_suffix() {
    return $this->admin_hook_suffix;
  }
}

new SG_Settings();