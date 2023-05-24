<div class="petition-custom-column-placeholder" id="petition-<?= $post_id ?>" data-petition-id="<?= $post_id ?>" v-cloak>
    <span v-if="loading">Loading...</span>
    <div v-else="loading">
        <div v-for="page in pages">
            <a :href="page.url" target="_blank">{{ page.title }} <small :style="`color: ${getColorByStatus(page.post_status)};`">({{page.post_status}})</small></a>
        </div>
    </div>
</div>