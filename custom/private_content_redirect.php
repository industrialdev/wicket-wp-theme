<?php

/**------------------------------------------------
 * For use with wp private content plus plugin
 * Appends the page to the url on redirect for where
 * the user was trying to go
 * filter applied here wp-private-content-plus\classes\class-wppcp-private-posts-pages.php:183
 * The main header login button then looks at this param and uses it if present
 ------------------------------------------------*/
function private_content_single_redirect(&$url)
{
    $url .= '?referrer=' . $_SERVER['REQUEST_URI'];
    $lang = 'en';
    if (defined('ICL_LANGUAGE_CODE')) {
        $lang = ICL_LANGUAGE_CODE;
    }
    if ($lang == 'fr') {
        return '/fr' . $url;
    } else {
        return $url;
    }
}
add_filter('wppcp_single_post_restriction_redirect', 'private_content_single_redirect', 10, 3);

function private_content_redirect(&$url)
{
    $url .= '?referrer=' . $_SERVER['REQUEST_URI'];
    $lang = 'en';
    if (defined('ICL_LANGUAGE_CODE')) {
        $lang = ICL_LANGUAGE_CODE;
    }
    if ($lang == 'fr') {
        return '/fr' . $url;
    } else {
        return $url;
    }
}
add_filter('wppcp_global_post_restriction_redirect', 'private_content_redirect', 10, 3);
