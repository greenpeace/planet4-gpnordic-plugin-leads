<?php
$condition = $form_type === 'multistep' ? true : '!success';

?>
<div class="leads-form__content" v-show="<?php echo $condition; ?>">
    <h2 :class="lengthClass(heroTitle)" v-if="heroTitle !== ''"><?php echo stripslashes($headline); ?></h2>
    <div class="description">
        <div class="text" ref="heroDescription" v-html="limitedText(heroDescription, textOpen)" v-if="heroDescription !== ''"><?php echo $description; ?>
        </div>
        <div v-if="showReadMore">
            <a @click="toggleText()" class='button--arrow'>
                <span class="arrow-icon" :class="{ 'arrow-icon--rotated' : textOpen }"><?php GPPL4\svg_icon('arrow--circle--down'); ?></span>
                <span v-text="moreButtonText"></span>
            </a>
        </div>
    </div>
</div>