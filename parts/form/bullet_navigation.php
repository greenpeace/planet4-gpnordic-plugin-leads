<nav class="leads-form__bullet-navigation">
  <ul>
    <li>
      <button @click="goToStep(0)" class="completed"><span><?php GPPL4\svg_icon('check'); ?></span></button>
    </li>
    <?php if ($steps) : foreach($steps as $key => $step) : 
      $step_index = $key + 1;
      ?>
      <li><button :class="[
        { 'active' : multistepActive === <?php echo $step_index; ?>}, 
        { 'skipped' : wasSkipped(<?php echo $step_index; ?>)},
        { 'completed' : wasCompleted(<?php echo $step_index; ?>)}
      ]" @click="goToStep(<?php echo $step_index; ?>)">
        <span v-if="wasSkipped(<?php echo $step_index; ?>)"><?php GPPL4\svg_icon('x'); ?></span>
        <span v-else-if="wasCompleted(<?php echo $step_index; ?>)"><?php GPPL4\svg_icon('check'); ?></span>
        <span v-else><?php echo $step_index + 1; ?></span>
      </button></li>
    <?php endforeach; endif; ?>
  </ul>
</nav>