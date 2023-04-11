
<?php 
if ($form_type === 'multistep') : ?>
    <div class="leads-form__thank-you">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="leads-form__thank-you__text"><?php echo stripslashes($description); ?></div>
        <div class="button-container">
            <a class="button button--primary" @click="goToStep(<?php echo $share_go_to_step; ?> - 1)"><?php echo $share_button_caption; ?></a> 
            <a class="button button--secondary" @click="goToStep(<?php echo $skip_go_to_step; ?> - 1)"><?php echo $skip_button_caption; ?></a>
        </div> 
        <?php 
            $prevNextData = array('stepIndex' => 0);
            GPPL4\get_partial("form/prev_next", $prevNextData);  
          ?>
    </div>
<?php else : ?>
    <div class="leads-form__thank-you-animation" ref="animation" v-show="showThankYouAnimation"></div>
    <div v-show="success" class="leads-form__thank-you">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="preamble"><?php echo stripslashes($description); ?></div>
    </div>
<?php endif; ?>

