<div v-show="success" class="leads-form__donate">
    <h4>
        <span class="leads-form__icon"><?php GPPL4\svg_icon('heart'); ?></span>
        <?php echo $thank_you_settings['donate_headline']; ?>
    </h4>
    <?php echo $thank_you_settings['donate_description']; ?>
    <div id="donate-container" class="donate-container">
      <?php if ($thank_you_settings['enable_donation_amount']) : ?>
        <div id="donate-input-amount" class="input-container">
            <input id="ghost" class="ghost donation-options" type="number" :min="blockData.donateMinimumAmount" pattern="[0-9]*" v-model="donateAmount" @keypress="numbersOnly($event)" @change="checkMinVal($event)"> <span class="currency"><?php echo $form_fields_translations['donate_currency']; ?></span>
        </div>
        <?php endif; ?>
        <a id="donate-button" :href="getDonateUrl(`<?php echo $thank_you_settings['donate_url']; ?>`)" class="button--submit button donation-options" target="_blank"><?php GPPL4\svg_icon('gift'); ?><?php echo $thank_you_settings['donate_cta']; ?></a>
    </div>
</div>