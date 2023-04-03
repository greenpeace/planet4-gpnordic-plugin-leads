<?php 
/**
 * Introduction content
 */
GPPL4\get_partial("form/content", $contentData); 
?>
<?php 
/**
 * The form
 */
GPPL4\get_partial("form/form", $formData); 
?>
<?php 
/**
 * Thank you
 */
GPPL4\get_partial("form/thank_you", $thankYouData); 
?>

<div v-show="success" class="leads-form__further-actions">
    <?php 
    /**
     * Counter
     */
    GPPL4\get_partial("form/counter", $counterData); 
             
    /**
     * Share
     */
    GPPL4\get_partial("form/share", $shareData); 
            
    /**
     * Donate
     */
    GPPL4\get_partial("form/donate", $donateData); 
    ?>
</div>