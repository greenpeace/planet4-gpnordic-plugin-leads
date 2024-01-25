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
    $secondary_color = GPPL4\hexToHsl(str_replace('#', '', $primary_color));
} else {
    $secondary_color = $brand_green_dark;
}

// Dark mode
$theme_option = $form_styles['colors']['theme'];
$theme = (isset($theme_option) && $theme_option != false) ? $theme_option : '';

// CTA text color
if (isset($form_styles['colors']['cta_text']) && $form_styles['colors']['cta_text'] != false) {
    $cta_text_color = $form_styles['colors']['cta_text'];
} elseif ($theme_option == 'dark') {
    $cta_text_color = $secondary_color;
} else {
    $cta_text_color = '#ffffff';
}

// Errors and successes color
$error_color = isset($form_styles['colors']['error']) ? $form_styles['colors']['error'] : "#FF785A";
$success_color = isset($form_styles['colors']['success']) ? $form_styles['colors']['success'] : "#73BE1E";


// Opacity
$opacity = (isset($form_styles['opacity']) && $form_styles['opacity'] != false) ? 'opacity--' . $form_styles['opacity'] : 'opacity--50';

// Alignment
$align = $form_styles['placement'];
$hero_description = (isset($hero_settings['description']) && $hero_settings['description'] != false) ? $hero_settings['description'] : '';

// Url
$url = get_the_permalink();

// Form type 
$form_type = get_field('form_type', $form_id);
// Multistep: steps
$steps = get_field('steps', $form_id);
$multistep_count = $steps && $steps['step'] ? count($steps['step']) + 2 : 0;

$has_multisteps = $form_type === 'multistep';

// Prepare data arrays for partials
$content_data = array(
    'form_type' => $form_type,
    'headline' => $hero_settings['headline'],
    'description' => $hero_description
);
$form_data = array(
    'form_type' => $form_type,
    'form_settings' => $form_settings,
    'form_fields_translations' => $form_fields_translations,
    'form_status' => $form_status,
    'display' => $display
);
$thank_you_data = array(
    'form_type' => $form_type,
    'share_button_caption' => $has_multisteps ? $steps['thank_you_share_button_caption'] : null,
    'skip_button_caption' => $has_multisteps ? $steps['thank_you_skip_button_caption'] : null,
    'share_go_to_step' => $has_multisteps ? 1 : null,
    'skip_go_to_step' => $has_multisteps ? 2 : null,
    'description' => $has_multisteps ? $steps['thank_you_description'] : $thank_you_settings['description'],
);
$counter_data = array(
    'form_settings' => $form_settings,
);
$share_data = array(
    'form_type' => $form_type,
    'headline' => $has_multisteps ? $steps['share_headline'] : $thank_you_settings['share_headline'],
    'description' => $has_multisteps ? $steps['share_description'] : $thank_you_settings['share_description'],
    'url' => $url
);
$donate_data = array(
    'form_type' => $form_type,
    'headline' => $has_multisteps ? $steps['donation_headline'] : $thank_you_settings['donate_headline'],
    'description' => $has_multisteps ? $steps['donation_description'] : $thank_you_settings['donate_description'],
    'donate_preset_amounts' => $has_multisteps ? $steps['donate_preset_amounts'] : null,
    'thank_you_settings' => $thank_you_settings,
    'enable_donation_amount' => $has_multisteps ? $steps['enable_donation_amount'] : $thank_you_settings['enable_donation_amount'],
    'donate_url' => $has_multisteps ? $steps['donate_url'] : $thank_you_settings['donate_url'],
    'donate_cta' => $has_multisteps ? $steps['donate_cta'] : $thank_you_settings['donate_cta'],
    'form_fields_translations' => $form_fields_translations
);
$final_data = array(
    'multistep_count' => $multistep_count,
    'final_all_completed_headline' => $has_multisteps ? $steps['final_all_completed_headline'] : null,
    'final_all_completed_description' => $has_multisteps ? $steps['final_all_completed_description'] : null,
    'final_all_completed_button_caption' => $has_multisteps ? $steps['final_all_completed_button_caption'] : null,
    'final_all_completed_button_url' => $has_multisteps ? $steps['final_all_completed_button_url'] : null,
    'final_incomplete_headline' => $has_multisteps ? $steps['final_incomplete_headline'] : null,
    'final_incomplete_description' => $has_multisteps ? $steps['final_incomplete_description'] : null,
    'final_incomplete_button_caption' => $has_multisteps ? $steps['final_incomplete_button_caption'] : null,
    'final_incomplete_button_url' => $has_multisteps ? $steps['final_incomplete_button_url'] : null
);
$custom_ask_data = array(
    'headline' => $has_multisteps ? $steps['custom_ask_headline'] : null,
    'description' => $has_multisteps ? $steps['custom_ask_description'] : null,
    'buttons' => $has_multisteps ? $steps['custom_ask_buttons'] : null
);
$layouts_data = array(
    'content_data' => $content_data,
    'form_data' => $form_data,
    'thank_you_data' => $thank_you_data,
    'counter_data' => $counter_data,
    'share_data' => $share_data,
    'donate_data' => $donate_data,
    'final_data' => $form_type === 'multistep' ? $final_data : false,
    'custom_ask_data' => $form_type === 'multistep' ? $custom_ask_data : false,
    'steps' => $form_type === 'multistep' ? $steps : false
);

?>
<div id="<?php echo esc_attr($id); ?>" :class="'leads-form--mounted'" class="<?php echo esc_attr($className) . " " . $display .  " " . $align . " " . $theme ?>" data-block-id="<?php echo $block['id']; ?>" data-form-id="<?php echo $form_id; ?>">

    <div class="leads-form__grid <?php if ($form_type === 'multistep') echo "leads-form__multistep"; ?> ">
        <?php
        if ($has_multisteps) {
            GPPL4\get_partial("form/layouts/multistep", $layouts_data);
        } else {
            GPPL4\get_partial("form/layouts/default", $layouts_data);
        }
        ?>
    </div>
    <?php if ($small_screen_image) : ?>
        <div ref="smallBkg" class="leads-form__bkg leads-form__bkg--small <?php echo $opacity; ?>" style="background-image: url(<?php echo $small_screen_image['url']; ?>);"></div>
    <?php endif; ?>
    <div ref="bkg" class="leads-form__bkg <?php echo $opacity; ?> <?php if ($small_screen_image) echo "leads-form__bkg--large" ?>" style="background-image: url(<?php echo $background_image; ?>);"></div>
    <div v-if="!success || formType === 'multistep'" class="leads-form__bottom-label"><?php GPPL4\svg_icon('hero-bottom-label'); ?></div>
</div>

<style>
    /* hide overflowing background on editor screen */
    .acf-block-component.acf-block-body .acf-block-preview {
        max-width: 70vw !important;
        overflow: hidden;
    }

    .leads-form {
        opacity: 1 !important;
    }

    /* Counter */
    #<?= "$id " ?>.leads-form__counter {
        background: <?php echo $secondary_color; ?>;
        color: <?php echo $cta_text_color; ?>;
    }

    #<?= "$id " ?>.leads-form__counter--success {
        background: transparent;
    }

    #<?= "$id " ?>.leads-form__counter__progress__bar {
        background: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__counter--success .leads-form__counter__headings {
        color: <?php echo $secondary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__counter__headings {
        color: <?php echo $primary_color; ?>;
    }

    /* Buttons */
    #<?= "$id " ?>.button:not(.button--ghost):not(.button--secondary),
    #<?= "$id " ?>.button--share {
        background: <?php echo $primary_color; ?>;
        color: <?php echo $cta_text_color; ?> !important;
        fill: <?php echo $cta_text_color; ?> !important;
    }

    #<?= "$id " ?>.button--donate-preset:not(.button--ghost) {
        border: 1px solid <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>.button--share svg path {
        fill: <?php echo $cta_text_color; ?> !important;
    }

    /* Style links */
    #<?= "$id " ?>.leads-form__form__container span a,
    #<?= "$id " ?>.leads-form__thank-you .preamble p a,
    #<?= "$id " ?>.leads-form__thank-you .preamble p span a  {
        border-bottom-color: <?php echo $primary_color; ?> !important;
    }

    #<?= "$id " ?>.leads-form__form__container span a:hover {
        color: <?php echo  $secondary_color; ?> !important;
        border-bottom-color: <?php echo  $secondary_color; ?> !important;
    }

    #<?= "$id " ?>.leads-form__thank-you .preamble p a:hover,
    #<?= "$id " ?>.leads-form__thank-you .preamble p span a:hover  {
        color: <?php echo $cta_text_color; ?> !important;
        border-bottom-color: <?php echo $cta_text_color; ?> !important;
    }

    /* implementing the winnig A/B test */
    #<?= "$id " ?>#facebook.button--share {
        background-color: #4267B2;
        box-shadow: 0 0 0 0 <?php echo GPPL4\hex2rgba($primary_color, 0.5); ?> !important;
        cursor: pointer;
        -webkit-animation: pulse 1.5s infinite;
        -moz-animation: pulse 1.5s infinite;
        animation: pulse 1.5s infinite;
        text-align: center;
        padding: 0.3rem 0.5rem;
        border-radius: 0.2rem;
        min-width: 9rem;
        max-height: 3.4rem;
    }

    #<?= "$id " ?>#facebook svg {
        padding-bottom: 0.2rem;
    }

    #<?= "$id " ?>#facebook svg path {
        fill: white !important;
    }

    #<?= "$id " ?>#facebook.button--share:hover {
        -webkit-animation: none;
        -moz-animation: none;
        animation: none;
    }

    #<?= "$id " ?>#facebook.button--share:active {
        -webkit-animation: none;
        -moz-animation: none;
        animation: none;
    }

    @-webkit-keyframes pulse {
        0% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        70% {
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -webkit-transform: scale(1);
            transform: scale(1);
            box-shadow: 0 0 0 50px rgba(90, 153, 212, 0);
        }

        100% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(90, 153, 212, 0);
        }
    }

    @-moz-keyframes pulse {
        0% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        70% {
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -webkit-transform: scale(1);
            transform: scale(1);
            box-shadow: 0 0 0 50px rgba(90, 153, 212, 0);
        }

        100% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(90, 153, 212, 0);
        }
    }

    @keyframes pulse {
        0% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        70% {
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -webkit-transform: scale(1);
            transform: scale(1);
            box-shadow: 0 0 0 50px rgba(90, 153, 212, 0);
        }

        100% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(90, 153, 212, 0);
        }
    }

    #<?= "$id " ?>#copy-link::before {
        display: none;
    }

    #<?= "$id " ?>#copy-link::before {
        display: none;
    }

    #<?= "$id " ?>#copy-link {
        background: <?php echo $primary_color; ?>;
        color: <?php echo $cta_text_color; ?>;
    }


    #<?= "$id " ?>#copy-link svg#link {
        margin-top: 0.25rem;
    }

    #<?= "$id " ?>#copy-link svg#link path {
        fill: <?php echo $cta_text_color; ?> !important;
        background: transparent !important;
    }

    /* Implementing the winning A/B test */
    /* #<?= "$id " ?>.button--share.email svg path {
        fill: transparent !important;
        stroke: <?php echo $cta_text_color; ?> !important;
    } */

    #<?= "$id " ?>.button--submit span,
    .button--submit svg path {
        color: <?php echo $cta_text_color; ?>;
        stroke: <?php echo $cta_text_color; ?>;
    }

    #<?= "$id " ?>h3 {
        color: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>a:not(.button--arrow):not(.button--submit):not(.button--ghost) {
        color: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bkg::after {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__icon {
        background-color: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__icon svg path {
        stroke: <?php echo $cta_text_color; ?>;
    }

    /* small screens */
    @media (max-width: 1140px) {

        /*
        #<?= "$id " ?>.description>.text,
        .description p {
            color: <?php echo $secondary_color; ?>;
        }
        #<?= "$id " ?>.leads-form__content h2 {
            color: <?php echo $secondary_color; ?>;
        }

        #<?= "$id " ?>.button--arrow {
            color: <?php echo $secondary_color; ?>;
        }

        #<?= "$id " ?>.button--arrow svg path {
            stroke: <?php echo $secondary_color; ?>;
        }
        */
    }

    /* Checkbox */
    #<?= "$id " ?>.checkbox {
        stroke: <?php echo $secondary_color; ?>;
        border-bottom-color: <?php echo $primary_color; ?>;
        border-left-color: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>.checkbox input:checked~.checkbox__box {
        border-color: <?php echo $primary_color; ?>;
        background-color: <?php echo GPPL4\hex2rgba($primary_color, 0.2); ?>;
    }

    #<?= "$id " ?>.checkbox .checkbox__box svg path {
        stroke: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>input:focus,
    input:active {
        border-color: <?php echo GPPL4\hex2rgba($primary_color, 0.6); ?>;
    }

    #<?= "$id " ?>input:focus~svg path,
    input:active~svg path {
        stroke: <?php echo $primary_color; ?>;
    }

    .leads-form {
        background-color: <?php echo $secondary_color; ?>;
    }

    /* Errors */

    #<?php echo $id; ?>.leads-form .input-container__error ul li {
        color: <?php echo $error_color; ?>;
        background-color: <?php echo GPPL4\hex2rgba($error_color, 0.1); ?>;
    }

    #<?= "$id " ?>input.error {
        border-color: <?php echo $error_color; ?> !important;
    }

    #<?= "$id " ?>input.error~svg path {
        stroke: <?php echo $error_color; ?> !important;
    }


    /* Dark mode */
    #<?php echo $id; ?>.dark .leads-form__form {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?php echo $id; ?>.dark .leads-form__multistep__step {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?php echo $id; ?>.dark .checkbox .checkbox__box {
        border-color: <?php echo $primary_color; ?>;
        background-color: <?php echo GPPL4\hex2rgba($primary_color, 0.2); ?>;
    }

    #<?php echo $id; ?>.dark input:-internal-autofill-selected,
    input:-webkit-autofill input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        background-color: <?php echo GPPL4\hex2rgba($primary_color, 0.8); ?> !important;
        -webkit-box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0), inset 0 0 0 100px <?php echo GPPL4\hex2rgba($primary_color, 0.8); ?> !important;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0), inset 0 0 0 100px <?php echo GPPL4\hex2rgba($primary_color, 0.8); ?> !important;
        color: white !important;
    }

    #<?php echo $id; ?>.dark .leads-form__counter {
        background-color: rgba(255, 255, 255, .05);
    }

    #<?php echo $id; ?>.dark .leads-form__counter__progress {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?php echo $id; ?>.dark .leads-form__counter--success {
        background: rgba(255, 255, 255, 0.25);
    }

    #<?= "$id " ?>.leads-form__form__container span a:hover {
        color: <?php echo  $cta_text_color; ?> !important;
        border-bottom-color: <?php echo  $cta_text_color; ?> !important;
    }

    /* Multistep */
    #<?= "$id " ?>.leads-form__multistep__step h2,
    #<?= "$id " ?>.leads-form__multistep__step h4 {
        color: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul::after {
        background-color: <?php echo GPPL4\hex2rgba($primary_color, 0.4); ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul li button,
    #<?= "$id " ?>.leads-form__bullet-navigation ul li .mock-button {
        border-color: <?php echo GPPL4\hex2rgba($primary_color, 0.4); ?>;
        color: <?php echo GPPL4\hex2rgba($primary_color, 0.4); ?>;
    }

    #<?php echo $id; ?>.dark .leads-form__bullet-navigation ul li button,
    #<?php echo $id; ?>.dark .leads-form__bullet-navigation ul li .mock-button {
        background-color: <?php echo $secondary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul li button.completed,
    #<?= "$id " ?>.leads-form__bullet-navigation ul li .mock-button.completed {
        border-color: <?php echo $success_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul li button.completed svg path,
    #<?= "$id " ?>.leads-form__bullet-navigation ul li .mock-button.completed svg path {
        fill: <?php echo $success_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul li button.skipped {
        border-color: <?php echo $error_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul li button.skipped svg path {
        fill: <?php echo $error_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul li button.active {
        color: white;
        border-color: <?php echo $primary_color; ?>;
        background-color: <?php echo $primary_color; ?>;
    }

    #<?= "$id " ?>.leads-form__bullet-navigation ul li button.active svg path {
        fill: white;
    }

    #<?= "$id " ?>.leads-form__multistep .button--secondary {
        background-color: <?php echo GPPL4\hex2rgba($primary_color, 0.4); ?>;
        color: <?php echo $primary_color; ?>
    }
</style>

<?php
$donate_amount_default = $form_type === 'multistep' ? $steps['donate_default_amount'] : $thank_you_settings['donate_default_amount'];
$donate_amount = $donate_amount_default ? $donate_amount_default : ($form_fields_translations['donate_minimum_amount'] ? $form_fields_translations['donate_minimum_amount'] : 0);
$ty_description = $form_type === 'multistep' ? $steps['thank_you_description'] : $thank_you_settings['description'];
?>
<script>
    window['leads_form_<?php echo $block['id']; ?>'] = {
        // toggle donations amount
        donateAmount: <?php echo $donate_amount; ?>,
        donateMinimumAmount: <?php echo $form_fields_translations['donate_minimum_amount'] ? $form_fields_translations['donate_minimum_amount'] : 0; ?>,
        thankYouTitle: '<?php echo addslashes($form_type === 'multistep' ? $steps['thank_you_headline'] : $thank_you_settings['headline']); ?>',
        thankYouDescription: '<?php echo addslashes(trim(preg_replace('/\s+/', ' ', trim($ty_description))));?>',
        pluginUrl: '<?php echo GPLP_PLUGIN_ROOT; ?>',
        //heroTitle trim slashes,remove tags and new lines
        heroTitle: '<?php echo addslashes(wp_strip_all_tags(trim(preg_replace('/\s\s+/', ' ', $hero_settings['headline'])))); ?>',
        heroDescription: "<?php echo addslashes(wp_strip_all_tags(trim(preg_replace('/\s\s+/', ' ', $hero_description)))); ?>",
        display: "<?php echo $display; ?>",
        formStyle: '<?php echo $form_settings['collapse_inputs']; ?>',
        enableCounter: '<?php echo $form_settings['enable_counter']; ?>',
        counter: <?php echo (int)(get_post_meta($form_id, 'count', true) ?: 0) + (int)$form_settings['counter']; ?>,
        counterGoalValue: '<?php echo $form_settings['counter_goal_value']; ?>',
        counterApiEndpoints: [<?php echo $form_settings['counter_api-endpoints'] ? join(',', array_map(function ($url) {
                                    return "\"${url['endpoint']}\"";
                                }, $form_settings['counter_api-endpoints'])) : ''; ?>],
        sourceCode: '<?php echo trim($form_settings['source_code'], " \t\n\r\0\x0B"); ?>',
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
                function () {
                    // parsing of the UTM values from a dynamic URL
                    const currentUTM = new URLSearchParams(window.location.search);
                    const postcodeInput = document.querySelector('input[type="tel"][name="postcode"]');

                    if (postcodeInput) {
                        const utmInputValue = postcodeInput.value;
                        currentUTM.set('utm_postcode', utmInputValue);

                        // Update the URL without reloading the page
                        const newURL = `${window.location.origin}${window.location.pathname}${currentUTM.toString() === '' ? '&' : '?'}${currentUTM.toString()}`;
                        window.history.replaceState({}, document.title, newURL);
                    }

                    // return the latest utm
                    return window.location.search;
                }, 
                fieldName: 'UTM',
                required: false,
                regex: ''
            },
            docref: {
                value: (!document.referrer || document.referrer.indexOf('greenpeace.org') !== -1) ?
                    (sessionStorage.getItem('lead_referrer')) : ((sessionStorage.getItem('lead_referrer') !== null) ?
                        (sessionStorage.getItem('lead_referrer')) :
                        (sessionStorage.setItem('lead_referrer', document.referrer), document.referrer)),
                fieldName: 'Referrer',
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
        },
        formType: '<?php echo $form_type; ?>',
        multistepCount: <?php echo $multistep_count; ?>,
        finalData: <?php echo json_encode($final_data); ?>,
        steps: <?php echo json_encode($steps); ?>
    };
</script>