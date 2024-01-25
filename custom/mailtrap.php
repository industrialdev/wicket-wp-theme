<?php

// MAILTRAP - used for staging/local dev
// Change the info below depending on your inbox. It can be found within the mailtrap inbox settings under "Wordpress"
// You typically also have to disable the WP SMTP mail plugin as well when needing to use this on stage/local

function mailtrap($phpmailer) {
  $phpmailer->isSMTP();
  $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
  $phpmailer->SMTPAuth = true;
  $phpmailer->Port = 2525;
  $phpmailer->Username = '[change this]';
  $phpmailer->Password = '[change this]';
}

$environment = get_option('wicket_admin_settings_environment');
if ($environment[0] != 'prod') {
  add_action('phpmailer_init', 'mailtrap');
}