<div class="leads-form__custom-ask">
  <h4><?php echo $headline; ?></h4>
  <?php echo $description; ?>
  <a @click="completeMultistep(<?php echo $step_index; ?>)" class="button button--share" href="<?php echo $button_url; ?>" target="_blank"><?php echo $button_caption; ?></a>
  <?php 
    $prev_next_data = array('step_index' => $step_index);
    GPPL4\get_partial("form/prev_next", $prev_next_data);  
  ?>
</div>