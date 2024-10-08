<?php

function get_shared_donate_fields() {
  return array(
    'enable_donation_amount' => [
      'label' => 'Enable default donation amount',
      'instructions' => 'Allow users to change the pre-defined amount, by showing the input field on the thank you page.',
      'message' => 'Display the pre-defined donation amount field',
      'default_value' => 1,
      'ui' => 1,
    ],
    'donate_default_amount' => [
      'label' => 'Default donation amount',
      'instructions' => 'The default donation amount in your local currency.',
      'default_value' => 10,
      'min' => 1,
      'max' => 1000,
      'step' => 1,
    ],
    'donate_cta' => [
      'label' => 'Donation button text',
      'default_value' => 'Donate now',
    ],
    'donate_url' => [
      'label' => 'Donation page URL',
      'instructions' => 'The checkout URL of the donation page, where %amount% is replaced by the user selected amount. The donation page can be changed by merely changing the \'page\' value in the URL below.',
      'default_value' => '',
    ],
  );
}