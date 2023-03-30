<?php
//Copy the page link to share
$checkLanguage = $_SERVER['REQUEST_URI'];
$checkLanguage = explode('/', $checkLanguage);
$checkLanguage = $checkLanguage[1];

$copyLink = "";

switch ($checkLanguage) {
  case "denmark":
    $copyLink = "Kopier link";
  break;
  case "finland":
    $copyLink = "Kopioi linkki";
  break;
  case "norway":
    $copyLink = "Kopier lenke";
  break;
  case "sweden":
    $copyLink = "Kopiera länk";
  break;
  default:
    $copyLink = "Copy link";
}
?>

<div class="leads-form__share">
    <h4>
        <span class="leads-form__icon"><?php svg_icon('share'); ?></span>
        <?php echo $thank_you_settings['share_headline']; ?>
    </h4>
    <?php echo $thank_you_settings['share_description']; ?>
    <div class="leads-form__share__icons">
        <a id="facebook" class="button button--share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>?<?php echo "share=facebook"; ?>" target="_blank"><?php svg_icon('facebook'); ?></a>
        <button id="copy-link" class="button button--share"><?php svg_icon('link'); ?><?php echo $copyLink; ?></button>
    </div>
</div>