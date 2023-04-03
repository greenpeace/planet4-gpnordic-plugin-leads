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
        GPPL4\get_partial("form/donate", $donateData); 
        break;
      case ('share') :
        /**
         * Share
         */
        GPPL4\get_partial("form/share", $shareData); 
        break;
      case ('custom_ask') :
        /**
         * Custom ask
         */
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