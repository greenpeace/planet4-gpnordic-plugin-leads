<div class="leads-form__final">
  <h4><?php echo $headline; ?></h4>
  <?php echo $description; ?>
  <a class="button button--share" href="<?php echo $button_url; ?>" target="_blank"><?php echo $button_caption; ?></a>
  <?php 
    $prevNextData = array('stepIndex' => $multistepCount - 1);
    GPPL4\get_partial("form/prev_next", $prevNextData);  
  ?>
</div>