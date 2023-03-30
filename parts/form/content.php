<div class="leads-form__content" v-show="!success">
    <h2 :class="lengthClass(heroTitle)" v-if="heroTitle !== ''"><?php echo stripslashes($headline); ?></h2>
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