<div class="leads-form__prev-next">
  <nav>

    <ul>
      <li v-show="!isFirst(<?php echo $stepIndex; ?> - 1)"><button @click="prevStep()">Go back</button></li>
      <li v-show="!wasCompleted(<?php echo $stepIndex; ?>) && !isLast(<?php echo $stepIndex; ?>)"><button @click="nextStep()">Skip that</button></li>
    </ul>
  </nav>
</div>