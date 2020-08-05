<h1>CSV Data Importer</h1>
<div class="cdi-wrapper">  
  <div class="form">
    <form action="" method="post" enctype="multipart/form-data">
      
      <div class="form__block">
        <label>Select CSV File</label>
        <input required type="file" name="cdi-csv-file"  />
      </div>

      <div class="form__block">
        <select required name="cdi-post-type" class="form__field form__field--select">
          <option value="" class="form__select">Select Custom Post Type</option>
          <?php foreach($post_types as $post_type){ echo "<option value='".$post_type."'>".$post_type."</option>"; } ?>
        </select>
      </div>

      <div class="form__acf-fields"></div>

      <div class="form__block">
        <input type="submit" name="cdi-submit-btn" value="Import" class="button button-primary form__field form__field--submit" />
      </div>

    </form>
  </div>
</div>