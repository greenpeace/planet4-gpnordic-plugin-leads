<div class="leads-form__multistep">
  <?php 

  /**
   * Navigation
   */
  GPPL4\get_partial("form/bullet_navigation", array('steps' => $steps['step']));

  /**
   * The form
   */
  GPPL4\get_partial("form/form", $formData);

  /**
   * Thank you
   */
  GPPL4\get_partial("form/thank_you", $thankYouData); 

  foreach($steps['step'] as $key => $step) : 
    // Increase by 2 to start navigation after Form and Thank you steps
    $stepIndex = $key + 2;
  ?>
    <div v-show="multistepActive === <?php echo $stepIndex; ?>">
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
  endforeach;
 
  /**
   * Final
   */
  $finalData['multistepCount'] = count($steps['step']);
  GPPL4\get_partial("form/final", $finalData); 
  ?>
</div>
