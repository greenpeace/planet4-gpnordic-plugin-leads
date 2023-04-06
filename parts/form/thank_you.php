
<?php 
if ($form_type === 'multistep') : ?>
    <div class="leads-form__thank-you">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="preamble"><?php echo stripslashes($description); ?></div>
        <a class="button" @click="goToStep(<?php echo $share_go_to_step; ?>)"><?php echo $share_button_caption; ?></a> 
        <a class="button" @click="goToStep(<?php echo $skip_go_to_step; ?>)"><?php echo $skip_button_caption; ?></a> 
    </div>
<?php else : ?>
    <div class="leads-form__thank-you-animation" ref="animation" v-show="showThankYouAnimation"></div>
    <div v-show="success" class="leads-form__thank-you">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="preamble"><?php echo stripslashes($description); ?></div>
    </div>
<?php endif; ?>

