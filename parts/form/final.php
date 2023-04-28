<div class="leads-form__final">
  <h4 v-text="completedAllAsks ? finalData.final_all_completed_headline : finalData.final_incomplete_headline"></h4>
  <div v-html="completedAllAsks ? finalData.final_all_completed_description : finalData.final_incomplete_description"></div>
  <a class="button button--share" :href="completedAllAsks ? finalData.final_all_completed_button_url : finalData.final_incomplete_button_url" target="_blank" v-text="completedAllAsks ? finalData.final_all_completed_button_caption : finalData.final_incomplete_button_caption" @click="pushDataLayer('action_final')"></a>
  <?php 
    $prev_next_data = array('step_index' => $multistep_count - 1);
    GPPL4\get_partial("form/prev_next", $prev_next_data);  
  ?>
</div>