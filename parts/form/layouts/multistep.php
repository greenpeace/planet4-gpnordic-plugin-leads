<?php 
/**
 * Introduction content
 */
GPPL4\get_partial("form/content", $content_data); 
?>
<div class="leads-form__multistep__container leads-form__main-container">
  <?php
  /**
   * The form
   */
  GPPL4\get_partial("form/form", $form_data);

  ?>
  <div class="leads-form__multistep__step" v-show="success">
    <?php 
    /**
     * Navigation
     */
    GPPL4\get_partial("form/bullet_navigation", array('steps' => $steps['step']));
    ?>

    <div :class="{ 'active' : multistepActive === 0 }">
      <?php 
      /**
       * Thank you
       */
      GPPL4\get_partial("form/thank_you", $thank_you_data); ?>
    </div>
  
    <?php
    if ($steps['step']) : 

      foreach($steps['step'] as $key => $step) : 
      // Increase by 1 to accommodate for "thank you" fake step
      $step_index = $key + 1;
    ?>
      <div :class="{ 'active' : multistepActive === <?php echo $step_index; ?>}">
        <?php
        switch($step['select_step']) {
          case ('donation') :
            /**
             * Donate
             */
            $donate_data['step_index'] = $step_index;
            GPPL4\get_partial("form/donate", $donate_data); 
            break;
          case ('share') :
            /**
             * Share
             */
            $share_data['step_index'] = $step_index;
            GPPL4\get_partial("form/share", $share_data); 
            break;
          case ('custom_ask') :
            /**
             * Custom ask
             */
            $custom_ask_data['step_index'] = $step_index;
            GPPL4\get_partial("form/custom_ask", $custom_ask_data); 
            break;
        }
      ?>
      </div>
    <?php 
    endforeach; endif;

    /**
     * Final
     */
    ?>
    <div :class="{ 'active' : multistepActive === multistepCount - 1 }">
      <?php GPPL4\get_partial("form/final", $final_data); ?>
    </div>
  </div>
</div>

