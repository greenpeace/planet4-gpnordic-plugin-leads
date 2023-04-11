<?php 
/**
 * Introduction content
 */
GPPL4\get_partial("form/content", $content_data); 

/**
 * The form
 */
GPPL4\get_partial("form/form", $form_data); 

/**
 * Thank you
 */
GPPL4\get_partial("form/thank_you", $thank_you_data); 
?>

<div v-show="success" class="leads-form__further-actions">
    <?php 
    /**
     * Counter
     */
    GPPL4\get_partial("form/counter", $counter_data); 
             
    /**
     * Share
     */
    GPPL4\get_partial("form/share", $share_data); 
            
    /**
     * Donate
     */
    GPPL4\get_partial("form/donate", $donate_data); 
    ?>
</div>