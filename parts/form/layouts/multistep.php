<div class="leads-form__multistep">
  <?php 

  /**
   * Navigation
   */
  GPPL4\get_partial("form/bullet_navigation", array('steps' => $steps['step']));

  /**
   * Thank you
   */
  GPPL4\get_partial("form/thank_you", $thankYouData); 

  foreach($steps['step'] as $key => $step) : 
    $stepIndex = $key + 1;
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
  GPPL4\get_partial("form/final", $finalData); 
  ?>
</div>
