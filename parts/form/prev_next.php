<?php
$form_fields_translations = get_field('form_fields_translations', 'options');

$skip_caption = $form_fields_translations['multistep_skip_step'] ?: 'Skip that';
$back_caption = $form_fields_translations['multistep_go_back_step'] ?: 'Go back';

?>

<div class="leads-form__prev-next">
  <nav>
    <ul>
      <li v-show="!isFirst(<?php echo $step_index; ?>)">
        <button @click="prevStep()">
          <?php GPPL4\svg_icon('chevron--left'); ?>
          <?php echo $back_caption; ?>
        </button>
      </li>
      <li v-show="!isLast(<?php echo $step_index; ?>)">
        <button @click="nextStep(), pushDataLayer('skip_step')">
          <?php echo $skip_caption; ?>
          <?php GPPL4\svg_icon('chevron--right'); ?>
        </button>
      </li>
    </ul>
  </nav>
</div>