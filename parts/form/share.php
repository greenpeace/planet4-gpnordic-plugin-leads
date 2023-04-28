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

$onCopyClick = $form_type === 'multistep' ? "completeMultistep($step_index), pushDataLayer('action_share', 'Copy link')" : "";

$share_url_copy_link = "$url?utm_source=copy_link&utm_medium=share_button";
$share_url_facebook = "$url?utm_source=facebook.com&utm_medium=share_button";
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
        <a @click="<?php echo $onCopyClick; ?>" id="facebook" class="button button--share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url_facebook; ?>" target="_blank"><?php GPPL4\svg_icon('facebook'); ?></a>
        <button @click="copyLink(`<?php echo $share_url_copy_link; ?>` <?php if ($form_type === 'multistep') echo ", $step_index"; ?>), pushDataLayer('action_share', 'Facebook')" id="copy-link" class="button button--share"><?php GPPL4\svg_icon('link'); ?><?php echo $copy_link_button_caption; ?></button>
    </div>
    <?php 
      if ($form_type === 'multistep') :
        $prev_next_data = array('step_index' => $step_index);
        GPPL4\get_partial("form/prev_next", $prev_next_data);  
      endif;
    ?>
</div>