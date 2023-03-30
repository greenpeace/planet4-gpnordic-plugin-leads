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

// Prepare data arrays for partials
$contentData = array(
    'headline' => $hero_settings['headline'],
    'description' => $hero_description
);
$formData = array(
    'form_settings' => $form_settings,
    'form_fields_translations' => $form_fields_translations,
    'form_status' => $form_status,
    'display' => $display
);
$thankYouData = array(
    'thank_you_settings' => $thank_you_settings
);
$counterData = array(
    'form_settings' => $form_settings,
);
$shareData = array(
    'thank_you_settings' => $thank_you_settings,
    'url' => $url,
);
$donateData = array(
    'thank_you_settings' => $thank_you_settings,
    'form_fields_translations' => $form_fields_translations
);
?>
<div id="<?php echo esc_attr($id); ?>" :class="'leads-form--mounted'" class="<?php echo esc_attr($className) . " " . $display .  " " . $align . " " . $theme ?>" data-block-id="<?php echo $block['id']; ?>" data-form-id="<?php echo $form_id; ?>">
    <div class="leads-form__grid">
        <?php 
        /**
         * Introduction content
         */
        planet4_get_partial("form/content", $contentData); 
        ?>
        <?php 
        /**
         * The form
         */
        planet4_get_partial("form/form", $formData); 
        ?>
        <?php 
        /**
         * Thank you
         */
        planet4_get_partial("form/thankyou", $thankYouData); 
        ?>

        <div v-show="success" class="leads-form__further-actions">
            <?php 
            /**
             * Counter
             */
            planet4_get_partial("form/counter", $counterData); 
             
            /**
             * Share
             */
            planet4_get_partial("form/share", $shareData); 
            
            /**
             * Donate
             */
            planet4_get_partial("form/donate", $donateData); 
            ?>
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

    /* implementing the winnig A/B test */
    #<?php echo $id . ' '; ?>#facebook.button--share {
      background-color : <?php echo $primary_color; ?>;
      box-shadow: 0 0 0 0 <?php echo hex2rgba($primary_color, 0.5); ?> !important;
      cursor: pointer;
      -webkit-animation: pulse 1.5s infinite;
      -moz-animation: pulse 1.5s infinite;
      animation: pulse 1.5s infinite;
      text-align: center;
      padding: 0.3rem 0.5rem;
      border-radius: 0.2rem;
      min-width: 9rem;
      max-width: fit-content;
      max-height: 3.4rem;
    }

    #<?php echo $id . ' '; ?>#facebook svg {
      padding-bottom: 0.2rem;
    }

    #<?php echo $id . ' '; ?>#facebook svg path {
      fill: <?php echo $cta_text_color; ?>;
    }

    #<?php echo $id . ' '; ?>#facebook.button--share:hover {
      -webkit-animation: none;
      -moz-animation: none;
      animation: none;
    }

    #<?php echo $id . ' '; ?>#facebook.button--share:active {
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

    #<?php echo $id . ' '; ?>#copy-link::before {
        display: none;
    }

    #<?php echo $id . ' '; ?>#copy-link::before {
        display: none;
    }

    #<?php echo $id . ' '; ?>#copy-link {
      background: <?php echo $primary_color; ?>;
      color: <?php echo $cta_text_color; ?>;
      border: none!important;
      border-radius: 0.2rem;
      padding: 0.3rem 1.6rem 0.1rem;
      word-break: keep-all;
      justify-content: center;
      align-items: center;
      text-align: center;
      cursor: pointer;
      min-width: fit-content;
      max-width: fit-content;
      width: fit-content;
      font-size: 1.4rem;
      line-height: 1.80rem;
      max-height: 3.4rem;
      -webkit-transition: all 0.3s ease-in-out;
      -moz-transition: all 0.3s ease-in-out;
      -ms-transition: all 0.3s ease-in-out;
      transition: all 0.3s ease-in-out;
    }


    #<?php echo $id . ' '; ?>#copy-link svg#link{
      margin-top: 0.25rem;
    }

    #<?php echo $id . ' '; ?>#copy-link svg#link path {
      fill: <?php echo $cta_text_color; ?> !important;
      background: transparent !important;
    }

    /* Implementing the winning A/B test */
    /* #<?php echo $id . ' '; ?>.button--share.email svg path {
        fill: transparent !important;
        stroke: <?php echo $cta_text_color; ?> !important;
    } */

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
        thankYouTitle: '<?php echo addslashes($thank_you_settings['headline']); ?>',
        pluginUrl: '<?php echo GPLP_PLUGIN_ROOT; ?>',
        //heroTitle trim slashes,remove tags and new lines
        heroTitle: '<?php echo addslashes(wp_strip_all_tags(trim(preg_replace('/\s\s+/', ' ', $hero_settings['headline'])))); ?>',
        heroDescription: "<?php echo addslashes(wp_strip_all_tags(trim(preg_replace('/\s\s+/', ' ', $hero_description)))); ?>",
        display: "<?php echo $display; ?>",
        formStyle: '<?php echo $form_settings['collapse_inputs']; ?>',
        enableCounter: '<?php echo $form_settings['enable_counter']; ?>',
        counter: '<?php echo ((int)get_post_meta($form_id, 'count', true) ?: 0) + (int)$form_settings['counter']; ?>',
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
                value: window.location.search, //the fixed parsing of the UTM values from the URL
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
