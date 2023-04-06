<nav class="leads-form__bullet-navigation" v-show="!isFirst(multistepActive)">
  <ul>
    <?php if ($steps) : foreach($steps as $key => $step) : 
      $stepIndex = $key + 1;
      ?>
      <li><button :class="[
        { 'active' : multistepActive === <?php echo $stepIndex; ?>}, 
        { 'skipped' : wasSkipped(<?php echo $stepIndex; ?>)},
        { 'completed' : wasCompleted(<?php echo $stepIndex; ?>)}
      ]" @click="goToStep(<?php echo $stepIndex; ?>)">
        <span v-if="wasSkipped(<?php echo $stepIndex; ?>)"><?php GPPL4\svg_icon('x'); ?></span>
        <span v-else-if="wasCompleted(<?php echo $stepIndex; ?>)"><?php GPPL4\svg_icon('check'); ?></span>
        <span v-else><?php echo $stepIndex; ?></span>
      </button></li>
    <?php endforeach; endif; ?>
  </ul>
</nav>