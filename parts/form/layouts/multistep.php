<?php 
/**
 * Introduction content
 */
GPPL4\get_partial("form/content", $contentData); 

/**
 * The form
 */
GPPL4\get_partial("form/form", $formData);

/**
 * Thank you
 */
?>
<div class="leads-form__multistep__step" v-show="multistepActive === 0 && success">
  <?php GPPL4\get_partial("form/thank_you", $thankYouData); ?>
</div>
<?php
if ($steps['step']) : 

  foreach($steps['step'] as $key => $step) : 
  // Increase by 2 to start navigation after Form and Thank you steps
  $stepIndex = $key + 1;
?>
  <div class="leads-form__multistep__step" v-show="multistepActive === <?php echo $stepIndex; ?>">
    <?php
    /**
     * Navigation
     */
    GPPL4\get_partial("form/bullet_navigation", array('steps' => $steps['step']));

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
<div class="leads-form__multistep__step" v-show="multistepActive === multistepCount - 1">
  <?php GPPL4\get_partial("form/final", $finalData); ?>
</div>

