<?php
//Copy the page link to share
$checkLanguage = $_SERVER['REQUEST_URI'];
$checkLanguage = explode('/', $checkLanguage);
$checkLanguage = $checkLanguage[1];

$copy_link_button_caption = "";

switch ($checkLanguage) {
  case "denmark":
    $copy_link_button_caption = "Kopier link";
  break;
  case "finland":
    $copy_link_button_caption = "Kopioi linkki";
  break;
  case "norway":
    $copy_link_button_caption = "Kopier lenke";
  break;
  case "sweden":
    $copy_link_button_caption = "Kopiera länk";
  break;
  default:
    $copy_link_button_caption = "Copy link";
}

$onClick = $form_type === 'multistep' ? "completeMultistep($step_index), pushDataLayer('action_share')" : "";
?>

<div class="leads-form__share">
    <h4>
        <?php if ($form_type !== 'multistep') : ?>
          <span class="leads-form__icon"><?php GPPL4\svg_icon('share'); ?></span>
        <?php endif; ?>
        <?php echo $headline; ?>
    </h4>
    <?php echo $description; ?>
    <div class="leads-form__share__icons">
        <a @click="<?php echo $onClick; ?>" id="facebook" class="button button--share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>?<?php echo "share=facebook"; ?>" target="_blank"><?php GPPL4\svg_icon('facebook'); ?></a>
        <button @click="copyLink(<?php if ($form_type === 'multistep') echo $step_index; ?>), pushDataLayer('action_share')" id="copy-link" class="button button--share"><?php GPPL4\svg_icon('link'); ?><?php echo $copy_link_button_caption; ?></button>
    </div>
    <?php 
      if ($form_type === 'multistep') :
        $prev_next_data = array('step_index' => $step_index);
        GPPL4\get_partial("form/prev_next", $prev_next_data);  
      endif;
    ?>
</div>