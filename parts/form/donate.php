<?php 
$condition = $form_type === 'multistep' ? true : 'success';
$onClick = $form_type === 'multistep' ? "completeMultistep($step_index), pushDataLayer('action_donation')" : "";
?>

<div v-show="<?php echo $condition; ?>" class="leads-form__donate">
    <h4>
        <?php if ($form_type !== 'multistep') : ?>
            <span class="leads-form__icon"><?php GPPL4\svg_icon('heart'); ?></span>
        <?php endif; ?>
        <?php echo $headline; ?>
    </h4>
    <?php echo $description; ?>
    <div id="donate-container" class="donate-container">
        <?php if ($enable_donation_amount) : ?>
            <?php if ($donate_preset_amounts) : ?>
                <ul class="donate-presets">
                    <?php foreach ($donate_preset_amounts as $preset) : ?>
                        <li>
                            <a class="button button--donate-preset" @click="setPreset(<?php echo $preset['amount']; ?>)" :class="{ 'button--ghost' : presetDonateAmount !== <?php echo $preset['amount']; ?>}">
                                <?php 
                                    echo $preset['amount']; 
                                    echo " " . $form_fields_translations['donate_currency']; 
                                ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div id="donate-input-amount" class="input-container">
                <input placeholder="<?php echo $form_fields_translations['donate_custom_amount'] ?>" id="ghost" class="ghost donation-options" type="number" :min="blockData.donateMinimumAmount" pattern="[0-9]*" :value="donateAmountInputValue" @keypress="numbersOnly($event), presetDonateAmount = 0" @keyup="setDonateAmount($event)" @change="checkMinVal($event), presetDonateAmount = 0, setDonateAmount($event)"> <span class="currency"><?php echo $form_fields_translations['donate_currency']; ?></span>
            </div>
        <?php endif; ?>
        <a @click="<?php echo $onClick; ?>" id="donate-button" :href="getDonateUrl(`<?php echo $donate_url; ?>`)" class="button--submit button donation-options" target="_blank"><?php GPPL4\svg_icon('gift'); ?><?php echo $donate_cta; ?></a>
    </div>
    <?php 
        if ($form_type === 'multistep') :
            $prev_next_data = array('step_index' => $step_index);
            GPPL4\get_partial("form/prev_next", $prev_next_data);  
        endif; 
      ?>
</div>