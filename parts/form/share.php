<?php

// function get_shared_share_fields() {
//   return array(
//     'enable_wa_message' => [
//       'label' => 'Enable default donation amount',
//       'instructions' => 'Customize your share message on Whatsapp',
//       'message' => 'Write a short message here (emojis not supoprted)',
//       'default_value' => 1,
//       'ui' => 1,
//     ],
//   );
// }

//Copy the page link to share
$checkLanguage = $_SERVER['REQUEST_URI'];
$checkLanguage = explode('/', $checkLanguage);
$checkLanguage = $checkLanguage[1];

$copy_link_button_caption = "";
$waMessage = rawurlencode($whatsapp_message);

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

$onFbClick = $form_type === 'multistep' ? "completeMultistep($step_index), pushDataLayer('action_share', 'Facebook')" : "";
$onWaClick = $form_type === 'multistep' ? "completeMultistep($step_index), pushDataLayer('action_share', 'Whatsapp')" : "";

$share_url_copy_link = "$url?utm_source=copy_link&utm_medium=share_button";
$share_url_facebook = "$url?utm_source=facebook.com%26utm_medium=share_button";
$share_url_whatsapp = "$url?utm_source=whatsapp.com%26utm_medium=share_button";

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
    <a @click="<?php echo $onFbClick; ?>" id="facebook" class="button button--share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url_facebook; ?>" target="_blank"><?php GPPL4\svg_icon('facebook'); ?></a>
    <?php if ($checkLanguage === 'finland' || $checkLanguage === 'sweden') : ?>
      <a @click="<?php echo $onWaClick; ?>" id="whatsapp" class="button button--share" href="https://api.whatsapp.com/send?text=<?php echo $waMessage; ?> <?php echo $share_url_whatsapp; ?>" target="_blank">
        <?php GPPL4\svg_icon('whatsapp'); ?> Whatsapp
      </a>
    <?php endif; ?> 
    <button @click="copyLink(`<?php echo $share_url_copy_link; ?>` <?php if ($form_type === 'multistep') echo ", $step_index"; ?>)" id="copy-link" class="button button--share"><?php GPPL4\svg_icon('link'); ?><?php echo $copy_link_button_caption; ?></button>
  </div>
  <?php
  if ($form_type === 'multistep') :
    $prev_next_data = array('step_index' => $step_index);
    GPPL4\get_partial("form/prev_next", $prev_next_data);
  endif;
  ?>
</div>