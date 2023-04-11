<?php 
/**
 * Introduction content
 */
GPPL4\get_partial("form/content", $contentData); 
?>
<div class="leads-form__multistep__container leads-form__main-container">
  <?php
  /**
   * The form
   */
  GPPL4\get_partial("form/form", $formData);

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
      GPPL4\get_partial("form/thank_you", $thankYouData); ?>
    </div>
  
    <?php
    if ($steps['step']) : 

      foreach($steps['step'] as $key => $step) : 
      // Increase by 1 to accommodate for "thank you" fake step
      $stepIndex = $key + 1;
    ?>
      <div :class="{ 'active' : multistepActive === <?php echo $stepIndex; ?>}">
        <?php
        switch($step['select_step']) {
          case ('donation') :
            /**
             * Donate
             */
            $donateData['stepIndex'] = $stepIndex;
            GPPL4\get_partial("form/donate", $donateData); 
            break;
          case ('share') :
            /**
             * Share
             */
            $shareData['stepIndex'] = $stepIndex;
            GPPL4\get_partial("form/share", $shareData); 
            break;
          case ('custom_ask') :
            /**
             * Custom ask
             */
            $customAskData['stepIndex'] = $stepIndex;
            GPPL4\get_partial("form/custom_ask", $customAskData); 
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
      <?php GPPL4\get_partial("form/final", $finalData); ?>
    </div>
  </div>
</div>

