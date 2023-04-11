<div class="leads-form__prev-next">
  <nav>
    <ul>
      <li v-show="!isFirst(<?php echo $stepIndex; ?>)">
        <button @click="prevStep()">
          <?php GPPL4\svg_icon('chevron--left'); ?>
          Go back
        </button>
      </li>
      <li v-show="!wasCompleted(<?php echo $stepIndex; ?>) && !isLast(<?php echo $stepIndex; ?>)">
        <button @click="nextStep()">
          Skip that
          <?php GPPL4\svg_icon('chevron--right'); ?>
        </button>
      </li>
    </ul>
  </nav>
</div>