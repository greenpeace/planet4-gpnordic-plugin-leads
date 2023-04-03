<nav class="leads-form__bullet-navigation">
  <ul>
    <?php foreach($steps as $key => $step) : 
      $stepIndex = $key + 1;
      ?>
      <li><button :class="[
        { 'active' : multistepActive === <?php echo $stepIndex; ?>}, 
        { 'skipped' : wasSkipped(<?php echo $stepIndex; ?>)},
        { 'completed' : wasCompleted(<?php echo $stepIndex; ?>)}
      ]" @click="goToStep(<?php echo $stepIndex; ?>)"><?php echo $stepIndex; ?></button></li>
    <?php endforeach; ?>
  </ul>
</nav>