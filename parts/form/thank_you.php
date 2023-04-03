
<?php 

if ($form_type === 'multistep') : ?>
    <div class="leads-form__thank-you" v-show="multistepActive === 0">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="preamble"><?php echo stripslashes($description); ?></div>
    </div>
<?php else : ?>
    <div class="leads-form__thank-you-animation" ref="animation" v-show="showThankYouAnimation"></div>
    <div v-show="success" class="leads-form__thank-you">
        <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
        <div class="preamble"><?php echo stripslashes($description); ?></div>
    </div>
<?php endif; ?>

