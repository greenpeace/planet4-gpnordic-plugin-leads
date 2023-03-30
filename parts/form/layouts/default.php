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