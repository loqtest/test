<?php
class SG_Files{

  static $filename = 'git-integration.sh';

  static function generate_sh_file($username, $password, $repo_link, $directory){
    $file_handler = fopen($directory .'/'. self::$filename, "w");

    if (!is_resource($file_handler)) {
        return false;
    }

    $sanized_repo_link = str_replace(['https://', 'http://'], "", $repo_link);
    $now_var = '$(date)';
    $commit_msg_var = '"$COMMIT_MSG"';

    fwrite($file_handler, "#!/bin/bash\n\n");
    fwrite($file_handler, 'COMMIT_MSG="'.$now_var.' updates"'."\n\n");
    fwrite($file_handler, "cd $directory\n");
    fwrite($file_handler, "git init\n");
    fwrite($file_handler, "git remote add origin https://$username:$password@$sanized_repo_link\n");
    fwrite($file_handler, "git add -A\n");
    fwrite($file_handler, "git commit -m $commit_msg_var\n");
    fwrite($file_handler, "git push --set-upstream origin master --force");

    fclose($file_handler);
  }

  static function generate_git_ignore_file($directory){
    $file_handler = fopen($directory .'/.gitignore', "w");

    if (!is_resource($file_handler)) {
        return false;
    }

    fwrite($file_handler, self::$filename);

    fclose($file_handler);
  }

  static function execute_sh_file($directory){
    return shell_exec('sh ' . $directory .'/'. self::$filename);
  }

  static function hasSHFileGenerated($directory){
    return file_exists($directory .'/'. self::$filename);
  }
}
