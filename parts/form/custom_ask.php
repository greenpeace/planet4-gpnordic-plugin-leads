<div class="leads-form__custom-ask">
  <h4><?php echo $headline; ?></h4>
  <?php echo $description; ?>
  <a @click="completeMultistep(<?php echo $stepIndex; ?>)" class="button button--share" href="<?php echo $button_url; ?>" target="_blank"><?php echo $button_caption; ?></a>
  <?php 
    $prevNextData = array('stepIndex' => $stepIndex);
    GPPL4\get_partial("form/prev_next", $prevNextData);  
  ?>
</div>