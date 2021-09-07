<?php

/**
 * leads-form Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" value.
$id = 'leads-form-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className".
$className = 'leads-form';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
$form_id = get_field('form');

// Get "Display" (size/format)
$display = get_field('display');

$form_settings = get_field('form_settings', $form_id);
$form_status = get_post_status($form_id);
$hero_settings = get_field('hero_settings', $form_id);
$thank_you_settings = get_field('thank_you_settings', $form_id);
$form_styles = get_field('form_styles', $form_id);
$extra_options = get_field('extra_options', $form_id);
$form_fields_translations = get_field('form_fields_translations', 'options');
// Background Image
$background_image = get_the_post_thumbnail_url($form_id, 'large');
// Small screen Image
$small_screen_image = $extra_options['small_screen_image'];

// Colors

$brand_green_light = "#73BE1E";
$brand_green_dark = "#005C42";

// Primary color
if (isset($form_styles['colors']['form_headline']) && $form_styles['colors']['form_headline'] != false) {
    $primary_color = $form_styles['colors']['form_headline'];
} else {
    $primary_color = $brand_green_light;
}
// Secondary color
if (isset($form_styles['colors']['cta_background']) && $form_styles['colors']['cta_background'] != false) {
    $secondary_color = $form_styles['colors']['cta_background'];
} elseif (isset($form_styles['colors']['form_headline']) && $form_styles['colors']['form_headline'] != false) {
    $secondary_color = hexToHsl(str_replace('#', '', $primary_color));
} else {
    $secondary_color = $brand_green_dark;
}

// Dark mode
$theme_option = $form_styles['colors']['theme'];
$theme = (isset($theme_option) && $theme_option != false) ? $theme_option : '';

//CTA text color

if (isset($form_styles['colors']['cta_text']) && $form_styles['colors']['cta_text'] != false) {
    $cta_text_color = $form_styles['colors']['cta_text'];
} elseif ($theme_option == 'dark') {
    $cta_text_color = $secondary_color;
} else {
    $cta_text_color = '#ffffff';
}


// Opacity
$opacity = (isset($form_styles['opacity']) && $form_styles['opacity'] != false) ? 'opacity--' . $form_styles['opacity'] : 'opacity--50';

// Alignment
$align = $form_styles['placement'];
$hero_description = (isset($hero_settings['description']) && $hero_settings['description'] != false) ? $hero_settings['description'] : '';

$url = get_the_permalink();
?>
<div id="<?php echo esc_attr($id); ?>" :class="'leads-form--mounted'" class="<?php echo esc_attr($className) . " " . $display .  " " . $align . " " . $theme ?>" data-block-id="<?php echo $block['id']; ?>" data-form-id="<?php echo $form_id; ?>">
    <div class="leads-form__grid">
        <div class="leads-form__content" v-show="!success">
            <h2 :class="lengthClass(heroTitle)" v-if="heroTitle !== ''"><?php echo $hero_settings['headline']; ?></h2>
            <div class="description">
                <div class="text" ref="heroDescription" v-html="limitedText(heroDescription, textOpen)" v-if="heroDescription !== ''"><?php echo $hero_description; ?>
                </div>
                <div v-if="showReadMore">
                    <a @click="toggleText()" class='button--arrow'>
                        <span class="arrow-icon" :class="{ 'arrow-icon--rotated' : textOpen }"><?php svg_icon('arrow--circle--down'); ?></span>
                        <span v-text="moreButtonText"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="leads-form__form" v-show="!success">
            <?php if ($form_settings['enable_counter']) : ?>
                <div class="leads-form__counter">
                    <div class="leads-form__counter__headings">
                        <small><?php echo $form_fields_translations['signed_up']; ?></small>
                        <small><?php echo $form_fields_translations['goal']; ?></small>
                    </div>
                    <div class="leads-form__counter__values">
                        <p>{{counter}}</p>
                        <p>{{blockData.counterGoalValue}}</p>
                    </div>

                    <div class="leads-form__counter__progress">
                        <div class="leads-form__counter__progress__bar" :style="{ width: `${percentReachedGoal}%` }" :class="{ 'done' : reachedGoal }"></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="leads-form__form__container">
                <?php if ($form_status !== 'publish') : ?>
                    <div class="leads-form__test">This form is not live!</div>
                <?php endif; ?>
                <?php if ($display != 'small') : ?>
                    <h3><?php echo $form_settings['headline']; ?></h3>
                    <?php echo $form_settings['description']; ?>
                <?php endif; ?>
                <div>
                    <div class="input-container">
                        <input @focus="hideInput = false; startedFilling = true" class="input--icon" type="email" name="email" placeholder="<?php echo $form_fields_translations['email']; ?>*" v-model="formFields.email.value" @keyup.enter="submit" />
                        <?php svg_icon('email'); ?>
                    </div>
                    <div v-if="hasFieldErrors(emailErrors)" class="input-container__error">
                        <ul>
                            <li v-for="(error, index) in emailErrors" :key="index" v-html="error"></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <div class="overflow-hidden">
                        <transition name="fade">
                            <div class="input-container name" v-show="!hideInput">
                                <input class="fname input--icon" type="text" name="fname" placeholder="<?php echo $form_fields_translations['first_name']; ?>*" v-model="formFields.fname.value" @keyup.enter="submit" />
                                <?php svg_icon('user'); ?>
                            </div>
                        </transition>
                        <transition name="fade">
                            <div class="input-container name" v-show="!hideInput">
                                <input class="lname" type="text" name="lname" placeholder="<?php echo $form_fields_translations['last_name']; ?>*" v-model="formFields.lname.value" @keyup.enter="submit" />
                            </div>
                        </transition>
                    </div>
                    <div v-if="hasFieldErrors(firstNameErrors) || hasFieldErrors(lastNameErrors)" class="input-container__error">
                        <ul>
                            <li v-for="(error, index) in firstNameErrors" :key="index" v-html="error"></li>
                            <li v-for="(error, index) in lastNameErrors" :key="index" v-html="error"></li>
                        </ul>
                    </div>
                </div>
                <?php if ($form_settings['phone'] !== 'false' && $display != 'small') : ?>
                    <transition name="fade">
                        <div v-show="!hideInput">
                            <div class="input-container phone">
                                <input class="countrycode" type="text" name="phone-countrycode" disabled placeholder="<?php echo $form_fields_translations['country_code']; ?>" value="<?php echo $form_fields_translations['country_code']; ?>">
                                <input class="input--icon" type="tel" name="phone" placeholder="<?php echo $form_fields_translations['phone']; ?><?php echo $form_settings['phone'] == 'required' ? '*' : ''; ?>" v-model="formFields.phone.value" @keyup.enter="submit" />
                                <?php svg_icon('phone'); ?>

                            </div>
                            <div v-if="hasFieldErrors(phoneErrors)" class="input-container__error">
                                <ul>
                                    <li v-for="(error, index) in phoneErrors" :key="index" v-html="error"></li>
                                </ul>
                            </div>
                        </div>
                    </transition>
                <?php endif; ?>
                <?php if ($form_settings['consent_method'] !== 'assumed') : ?>
                    <div class="checkbox-container">
                        <div class="checkbox">
                            <input type="checkbox" name="terms" v-model="formFields.consent.value" />
                            <span class="checkbox__box">
                                <?php svg_icon('check'); ?>
                            </span>
                            <span class="checkbox-label">
                                <?php echo $form_settings['consent_message'] !== '' ? $form_settings['consent_message'] : $form_fields_translations['terms_agree']; ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
                <a @click="submit" class="button button--submit">
                    <span v-if="!loading"><?php svg_icon('send-message'); ?></span>
                    <span v-html="loading ? '<?php echo $form_fields_translations['sending']; ?>' : '<?php echo addslashes($form_settings['call_to_action']); ?>'"></span>
                </a>
                <?php if ($form_settings['consent_method'] === 'assumed') : ?>
                    <small><?php echo $form_settings['consent_message'] !== '' ? $form_settings['consent_message'] : $form_fields_translations['terms_agree']; ?></small>
                <?php endif; ?>
            </div>
        </div>
        <div class="leads-form__thank-you-animation" ref="animation" v-show="showThankYouAnimation"></div>
        <div v-show="success" class="leads-form__thank-you">
            <h2 :class="lengthClass(thankYouTitle)" v-html="thankYouTitle"></h2>
            <div class="preamble"><?php echo $thank_you_settings['description']; ?></div>
        </div>

        <div v-show="success" class="leads-form__further-actions">
            <?php if ($form_settings['enable_counter']) : ?>
                <div class="leads-form__counter leads-form__counter--success">
                    <div class="leads-form__counter__headings">
                        <small>Signed up</small>
                        <small>Goal</small>
                    </div>
                    <div class="leads-form__counter__values">
                        <p>{{counter}}</p>
                        <p>{{blockData.counterGoalValue}}</p>
                    </div>

                    <div class="leads-form__counter__progress">
                        <div class="leads-form__counter__progress__bar" :style="{ width: `${percentReachedGoal}%` }" :class="{ 'done' : reachedGoal }"></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="leads-form__share">
                <h4>
                    <span class="leads-form__icon"><?php svg_icon('share'); ?></span>
                    <?php echo $thank_you_settings['share_headline']; ?>
                </h4>
                <?php echo $thank_you_settings['share_description']; ?>
                <div class="leads-form__share__icons">
                    <a id="facebook" class="button--share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>?<?php echo "share=facebook"; ?>" target="_blank"><?php svg_icon('facebook'); ?></a>
                    <a id="twitter" class="button--share" href="https://twitter.com/intent/tweet?text=<?php echo $url; ?> <?php echo urlencode($thank_you_settings['twitter_share_text']); ?>" target="_blank"><?php svg_icon('twitter'); ?></a>
                    <a id="email" class="button--share email" href="mailto:?subject=<?php echo rawurlencode($thank_you_settings['email_share_subject']); ?>&amp;body=<?php echo rawurlencode(str_replace('%site_url%', $url, $thank_you_settings['email_share_text'])); ?>" target="_blank"><?php svg_icon('email'); ?></a>
                    <a id="whatsapp" class="button--share" href="https://wa.me/?text=<?php echo $url; ?><?php echo urlencode($thank_you_settings['whatsapp_share_text']); ?>?<?php echo "share=whatsapp"; ?>" target="_blank"><?php svg_icon('whatsapp'); ?></a>
                </div>
            </div>
            <div v-show="success" class="leads-form__donate">
                <h4>
                    <span class="leads-form__icon"><?php svg_icon('heart'); ?></span>
                    <?php echo $thank_you_settings['donate_headline']; ?>
                </h4>
                <?php echo $thank_you_settings['donate_description']; ?>
                <div id="donate-container" class="donate-container">
                  <?php if ($thank_you_settings['enable_donation_amount']) : ?>
                    <div id="donate-input-amount" class="input-container">
                        <input id="ghost" class="ghost donation-options" type="number" :min="blockData.donateMinimumAmount" pattern="[0-9]*" v-model="donateAmount" @keypress="numbersOnly($event)" @change="checkMinVal($event)"> <span class="currency"><?php echo $form_fields_translations['donate_currency']; ?></span>
                    </div>
                    <?php endif; ?>
                    <a id="donate-button" :href="getDonateUrl(`<?php echo $thank_you_settings['donate_url']; ?>`)" class="button--submit button donation-options" target="_blank"><?php svg_icon('gift'); ?><?php echo $thank_you_settings['donate_cta']; ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($small_screen_image) : ?>
        <div ref="smallBkg" class="leads-form__bkg leads-form__bkg--small <?php echo $opacity; ?>" style="background-image: url(<?php echo $small_screen_image['url']; ?>);"></div>
    <?php endif; ?>
    <div ref="bkg" class="leads-form__bkg <?php echo $opacity; ?> <?php if ($small_screen_image) echo "leads-form__bkg--large" ?>" style="background-image: url(<?php echo $background_image; ?>);"></div>
    <div v-if="!success" class="leads-form__bottom-label"><?php svg_icon('hero-bottom-label'); ?></div>
</div>

<style>
    /* hide overflowing background on editor screen */
    .acf-block-component.acf-block-body .acf-block-preview {
    max-width: 70vw !important;
    overflow: hidden;
    }
    .leads-form {opacity: 1 !important;}
    /* Counter */
    #<?php echo $id . ' '; ?>.leads-form__counter {
        background: <?php echo $secondary_color; ?>;
        color: <?php echo $cta_text_color; ?>;
    }

    #<?php echo $id . ' '; ?>.leads-form__counter--success {
        background: transparent;
    }

    #<?php echo $id . ' '; ?>.leads-form__counter__progress__bar {
        background: <?php echo $primary_color; ?>;
    }

    #<?php echo $id . ' '; ?>.leads-form__counter--success .leads-form__counter__headings {
        color: <?php echo $secondary_color; ?>;
    }

    #<?php echo $id . ' '; ?>.leads-form__counter__headings {
        color: <?php echo $primary_color; ?>;
    }

    /* Buttons */
    #<?php echo $id . ' '; ?>.button,
    #<?php echo $id . ' '; ?>.button--share {
        background: <?php echo $primary_color; ?>;
        color: <?php echo $cta_text_color; ?> !important;
        fill: <?php echo $cta_text_color; ?> !important;
    }

    #<?php echo $id . ' '; ?>.button--share svg path {
        fill: <?php echo $cta_text_color; ?> !important;
    }

    #<?php echo $id . ' '; ?>.button--share.email svg path {
        fill: transparent !important;
        stroke: <?php echo $cta_text_color; ?> !important;
    }

    #<?php echo $id . ' '; ?>.button--submit span,
    .button--submit svg path {
        color: <?php echo $cta_text_color; ?>;
        stroke: <?php echo $cta_text_color; ?>;
    }

    #<?php echo $id . ' '; ?>h3 {
        color: <?php echo $primary_color; ?>;
    }

    #<?php echo $id . ' '; ?>a:not(.button--arrow):not(.button--submit) {
        color: <?php echo $primary_color; ?>;
    }

    #<?php echo $id . ' '; ?>.leads-form__bkg::after {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?php echo $id . ' '; ?>.leads-form__icon {
        background-color: <?php echo $primary_color; ?>;
    }

    #<?php echo $id . ' '; ?>.leads-form__icon svg path {
        stroke: <?php echo $cta_text_color; ?>;
    }

    /* small screens */
    @media (max-width: 1140px) {

        /*
        #<?php echo $id . ' '; ?>.description>.text,
        .description p {
            color: <?php echo $secondary_color; ?>;
        }
        #<?php echo $id . ' '; ?>.leads-form__content h2 {
            color: <?php echo $secondary_color; ?>;
        }

        #<?php echo $id . ' '; ?>.button--arrow {
            color: <?php echo $secondary_color; ?>;
        }

        #<?php echo $id . ' '; ?>.button--arrow svg path {
            stroke: <?php echo $secondary_color; ?>;
        }
        */
    }

    /* Checkbox */
    #<?php echo $id . ' '; ?>.checkbox {
        stroke: <?php echo $secondary_color; ?>;
        border-bottom-color: <?php echo $primary_color; ?>;
        border-left-color: <?php echo $primary_color; ?>;
    }

    #<?php echo $id . ' '; ?>.checkbox input:checked~.checkbox__box {
        border-color: <?php echo $primary_color; ?>;
        background-color: <?php echo hex2rgba($primary_color, 0.2); ?>;
    }

    #<?php echo $id . ' '; ?>.checkbox .checkbox__box svg path {
        stroke: <?php echo $primary_color; ?>;
    }

    #<?php echo $id . ' '; ?>input:focus,
    input:active {
        border-color: <?php echo hex2rgba($primary_color, 0.6); ?>;
    }

    #<?php echo $id . ' '; ?>input:focus~svg path,
    input:active~svg path {
        stroke: <?php echo $primary_color; ?>;
    }

    .leads-form {
        background-color: <?php echo $secondary_color; ?>;
    }

    /* Dark mode */
    #<?php echo $id; ?>.dark .leads-form__form {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?php echo $id; ?>.dark .checkbox .checkbox__box {
        border-color: <?php echo $primary_color; ?>;
        background-color: <?php echo hex2rgba($primary_color, 0.2); ?>;
    }

    #<?php echo $id; ?>.dark input:-internal-autofill-selected,
    input:-webkit-autofill input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        background-color: <?php echo hex2rgba($primary_color, 0.8); ?> !important;
        -webkit-box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0), inset 0 0 0 100px <?php echo hex2rgba($primary_color, 0.8); ?> !important;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0), inset 0 0 0 100px <?php echo hex2rgba($primary_color, 0.8); ?> !important;
        color: white !important;
    }

    #<?php echo $id; ?>.dark .leads-form__counter {
        background-color: rgba(255,255,255,.05);
    }

    #<?php echo $id; ?>.dark .leads-form__counter__progress {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?php echo $id; ?>.dark .leads-form__counter--success {
        background: rgba(255, 255, 255, 0.25);
    }
</style>

<script>
    window['leads_form_<?php echo $block['id']; ?>'] = {
        // toggle donations amount
        donateAmount: <?php echo $thank_you_settings['donate_default_amount'] ? $thank_you_settings['donate_default_amount'] : ($form_fields_translations['donate_minimum_amount'] ? $form_fields_translations['donate_minimum_amount'] : 0); ?>,
        donateMinimumAmount: <?php echo $form_fields_translations['donate_minimum_amount'] ? $form_fields_translations['donate_minimum_amount'] : 0; ?>,
        thankYouTitle: '<?php echo $thank_you_settings['headline']; ?>',
        pluginUrl: '<?php echo GPLP_PLUGIN_ROOT; ?>',
        heroTitle: '<?php echo $hero_settings['headline']; ?>',
        heroDescription: "<?php echo trim(preg_replace('/\s\s+/', ' ', strip_tags($hero_description))); ?>",
        display: "<?php echo $display; ?>",
        formStyle: '<?php echo $form_settings['collapse_inputs']; ?>',
        enableCounter: '<?php echo $form_settings['enable_counter']; ?>',
        counter: '<?php echo ((int)get_post_meta($form_id, 'count', true) ?: 0) + (int)$form_settings['counter']; ?>',
        counterGoalValue: '<?php echo $form_settings['counter_goal_value']; ?>',
        counterApiEndpoints: [<?php echo $form_settings['counter_api-endpoints'] ? join(',', array_map(function ($url) {
                                    return "\"${url['endpoint']}\"";
                                }, $form_settings['counter_api-endpoints'])) : ''; ?>],
        sourceCode: '<?php echo $form_settings['source_code']; ?>',
        readMore: '<?php echo $form_fields_translations['read_more']; ?>',
        readLess: '<?php echo $form_fields_translations['read_less']; ?>',
        formFields: {
            form_id: {
                value: <?php echo $form_id ? $form_id : 'false'; ?>,
                fieldName: 'Form ID',
                required: false,
                regex: ''
            },
            utm: {
                value: '<?php echo isset($_GET['utm']) ? $_GET['utm'] : ''; ?>',
                fieldName: 'UTM',
                required: false,
                regex: ''
            },
            fname: {
                value: '',
                id: 'fname',
                fieldName: '<?php echo $form_fields_translations['first_name']; ?>',
                required: true,
                regex: /^([^0-9]*){2,30}$/
            },
            lname: {
                value: '',
                id: 'lname',
                fieldName: '<?php echo $form_fields_translations['last_name']; ?>',
                required: true,
                regex: /^([^0-9]*){2,30}$/
            },
            email: {
                value: '',
                id: 'email',
                fieldName: '<?php echo $form_fields_translations['email']; ?>',
                required: true,
                regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            },
            phone: {
                value: '',
                id: 'phone',
                fieldName: '<?php echo $form_fields_translations['phone']; ?>',
                required: <?php echo $form_settings['phone'] == 'required' ? 1 : 0; ?>,
                regex: /^[0-9]{6,11}$/
            },
            consent: {
                value: <?php echo var_export((bool)($form_settings['consent_method'] == 'checkbox_checked' || $form_settings['consent_method'] == 'assumed'), true); ?>,
                fieldName: "<?php echo trim(preg_replace('/\s\s+/', ' ', strip_tags($form_fields_translations['terms_agree']))); ?>",
                required: false,
                regex: ''
            },
        },
        errorMessages: {
            required: '<?php echo $form_fields_translations['error_required']; ?>',
            format: '<?php echo $form_fields_translations['error_format']; ?>'
        }
    };
</script>
