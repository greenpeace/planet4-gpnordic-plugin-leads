<div class="leads-form__custom-ask">
  <h4><?php echo $headline; ?></h4>
  <?php echo $description; ?>
  <?php if ($buttons) : ?>
    <div class="button-container">
      <?php foreach ($buttons as $button) : ?>
        <a @click="completeMultistep(<?php echo $step_index; ?>), pushDataLayer('action_custom_ask')" class="button button--share" href="<?php echo $button['button_url']; ?>" style="background-color: <?php echo $button['button_color']; ?>!important; color: <?php echo $button['button_text_color']; ?>!important;" target="_blank"><?php echo $button['button_caption']; ?></a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?> 
  <?php 
    $prev_next_data = array('step_index' => $step_index);
    GPPL4\get_partial("form/prev_next", $prev_next_data);  
  ?>
</div>