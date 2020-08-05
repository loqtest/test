<h1>Suitebee Git</h1>
<div class="suitebee-git-settings">
  <div class="form">
    <form action="" method="post" enctype="multipart/form-data">

      <div class="form__block">
        <label>Git Username</label>
        <input type="text" name="usernane" required value="<?php echo get_option('sg_username'); ?>">
      </div>

      <div class="form__block">
        <label>Git Password</label>
        <input type="password" name="password" required value="<?php echo get_option('sg_password'); ?>">
      </div>

      <div class="form__block">
        <label>Repo Link</label>
        <input type="text" name="repo" required value="<?php echo get_option('sg_repo'); ?>">
      </div>

      <div class="form__block">
        <label>Target Directory</label>
        <input type="text" name="directory" required value="<?php echo get_option('sg_directory'); ?>">
      </div>

      <div class="form__block">
        <input type="submit" name="sg-submit-btn" value="Generate SH File" class="button button-primary form__field form__field--submit" />
      </div>

    </form>
  </div>
</div>