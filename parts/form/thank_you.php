<?php
if ($form_type === 'multistep') : ?>
    <div class="leads-form__thank-you">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="preamble" v-html="thankYouDescription"></div>
        <div class="button-container">
            <a class="button button--primary" @click="goToStep(<?php echo $share_go_to_step; ?>), pushDataLayer('thank_you_yes')"><?php echo $share_button_caption; ?></a>
            <a class="button button--secondary" @click="disagreeToShare(<?php echo $share_go_to_step; ?>, <?php echo $skip_go_to_step; ?>), pushDataLayer('thank_you_no')"><?php echo $skip_button_caption; ?></a>
        </div>
    </div>
<?php else : ?>
    <div class="leads-form__thank-you-animation" ref="animation" v-show="showThankYouAnimation"></div>
    <div v-show="success" class="leads-form__thank-you">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="preamble" v-html="thankYouDescription"></div>
    </div>
<?php endif; ?>