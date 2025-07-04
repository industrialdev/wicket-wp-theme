<?php
$lang = 'en';
$locale = '&locale=en';
if (defined('ICL_LANGUAGE_CODE')) {
    $locale = ICL_LANGUAGE_CODE == 'fr' ? '&locale=fr' : '&locale=en';
    $lang = ICL_LANGUAGE_CODE;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/icons/favicon.ico">

    <!-- Touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo get_template_directory_uri(); ?>/assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/icons/favicon-16x16.png"
        sizes="16x16">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/icons/favicon-32x32.png"
        sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/icons/mstile-150x150.png"
        sizes="150x150">
    <link rel="icon" type="image/png"
        href="<?php echo get_template_directory_uri(); ?>/assets/icons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png"
        href="<?php echo get_template_directory_uri(); ?>/assets/icons/android-chrome-512x512.png" sizes="512x512">

    <!-- Font Family -->
    <?php
    $theme_ff_group = get_field('theme-font-family', 'option') ?: [];
if (!empty($theme_ff_group['head-font-html-code'])) {
    echo $theme_ff_group['head-font-html-code'];
}

wp_head();

the_field('tracking_codes_in_head', 'options');
?>
</head>

<body <?php body_class(); ?>>
    <?php do_action('wp_body_open'); ?>
    <?php echo get_field('tracking_codes_right_after_body', 'options'); ?>
    <a class="transition left-0 bg-primary text-primary-content absolute p-3 m-3 -translate-y-32 z-10 bg-[--bg-white] focus:translate-y-0"
        href="#main-content">
        <?php echo __('Skip to main content', 'wicket'); ?>
    </a>

    <?php
// Set PHP variables needed for secondary nav
$logo = get_field('site_logo', 'options');
$logo_url = $logo['url'] ?? get_template_directory_uri() . '/assets/images/logo-' . $lang . '.svg' ?? '';
$default_account_path = $lang == 'fr' ? '/fr/create-account' : '/create-account';

/**
 ** Set "Become a Member" link.
 */
$display_bam_link = get_field('display_bam_link', 'options') ?? true;
$bam_button_style = get_field('bam_button_style', 'options') ?? 'primary';
$bam_link_array = get_field('bam_link', 'options');

$bam_url = $default_account_path;
$bam_label = __('Become a member', 'wicket');
$bam_target_attr = '_self';

if (is_array($bam_link_array)) {
    $bam_url = $bam_link_array['url'];
    $bam_label = $bam_link_array['title'];
    $bam_target_attr = $bam_link_array['target'];
}
/**
 ** END "Become a Member" link.
 */

/**
 ** Set "Create Account" link.
 */
$display_create_account_link = get_field('display_create_account_link', 'options') ?? true;
$create_account_button_style = get_field('create_account_button_style', 'options') ?? 'primary';
$create_account_link_array = get_field('create_account_link', 'options');

$create_account_url = $default_account_path;
$create_account_label = __('Create Account', 'wicket');
$create_account_target_attr = '_self';

if (is_array($create_account_link_array)) {
    $create_account_url = $create_account_link_array['url'];
    $create_account_label = $create_account_link_array['title'];
    $create_account_target_attr = $create_account_link_array['target'];
}
/**
 ** END "Create Account" link.
 */
$acc_index_url = get_post_type_archive_link('my-account');
if ($acc_index_url) {
    $account_center_landing = $acc_index_url;
    $acc_index_url = $acc_index_url . $locale;
} else {
    $account_center_slug_locale = get_field('ac_localization', 'option');
    if (empty($account_center_slug_locale['value'])) {
        $account_center_slug_locale['value'] = 'account-center';
    }
    $account_center_landing = $lang == 'fr' ? '/fr/mon-compte' : '/' . $account_center_slug_locale['value'];

    $acc_index_url = $account_center_landing . $locale;
}
$referrer = isset($_GET['referrer']) ? wicket_get_site_root_url() . $_GET['referrer'] . $locale : $acc_index_url;

$cart_path = $lang == 'fr' ? '/fr/cart' : '/cart';
$nav_state = 'logged_out'; // Will be one of logged_out, logged_in_user, logged_in_member
if (is_user_logged_in()) {
    $nav_state = 'logged_in_user';

    $user = wp_get_current_user();
    if (in_array('member', (array) $user->roles)) {
        $nav_state = 'logged_in_member';
    }

    if (in_array('administrator', (array) $user->roles)) {
        $nav_state = 'logged_in_member';
    }
}

// Grab Menus
$theme_locations = get_nav_menu_locations();
if (isset($theme_locations['header-utility'])) {
    $utility_nav_items = wp_get_nav_menu_items($theme_locations['header-utility']);
} else {
    $utility_nav_items = [];
}
if (isset($theme_locations['header-secondary'])) {
    $secondary_nav_items = wp_get_nav_menu_items($theme_locations['header-secondary']);
} else {
    $secondary_nav_items = [];
}
if (isset($theme_locations['header'])) {
    $primary_nav_items = wp_get_nav_menu_items($theme_locations['header']);
} else {
    $primary_nav_items = [];
}
// Create better primary nav array
$primary_nav_items_structured = wicket_generate_structured_menu($primary_nav_items);

// Data formatted for Alpine
$show_search = get_field('secondary_nav_search_enabled', 'options') ? 'true' : 'false';
$show_cart = get_field('secondary_nav_cart_enabled', 'options') ? 'true' : 'false';
$show_utility = !empty($utility_nav_items) ? 'true' : 'false';
$sub_menu_dropdowns = get_field('mobile_menu_sub_menu_dropdowns', 'options') ? 'true' : 'false';
?>
    <header x-data="{
			searchOpen:     false,
			showSearch:     <?php echo $show_search; ?>,
			showCart:     <?php echo $show_cart; ?>,
			showUtilityNav: <?php echo $show_utility; ?>,
			mobileMenuOpen: false,
			mobileMenuMegaSubDropdowns: <?php echo $sub_menu_dropdowns; ?>,
		}" class="w-full flex flex-col site-header">
        <!-- Utility Nav -->
        <div x-show="showUtilityNav" x-cloak class="utility-nav">
            <div class="container utility-nav__wrap">
                <?php
            $utility_loop_index = 0;
foreach ($utility_nav_items as $utility_nav_item) {
    $target = $utility_nav_item->target ?? '';
    get_component('link', [
        'text'    => $utility_nav_item->title,
        'classes' => ['utility-nav__link'],
        'target'  => $target,
        'url'     => $utility_nav_item->url,
    ]);
    $utility_loop_index++;
}
?>
            </div>
        </div> <!-- End Utility Nav -->

        <!-- Secondary Nav (Logo, login button, language switcher, etc.) -->
        <div x-ref="secondary-nav" class="secondary-nav">
            <div class="container flex items-center justify-between relative">
                <!-- Left-aligned hamburger menu button that only shows on Base/SM breakpoints -->
                <?php
get_component('button', [
    'variant'     => 'ghost',
    'button_aria' => [
        'label' => 'Open Menu',
    ],
    'classes'     => ['left-hamburger-button', 'inline-flex', 'md:hidden'],
    'id'          => 'left-hamburger-button',
    'label'       => '',
    'prefix_icon' => 'fa-solid fa-bars',
    'atts'        => [
        'x-cloak',
        ':class = "mobileMenuOpen ? \'open\' : \'\'"',
        'x-on:click="mobileMenuOpen = ! mobileMenuOpen; if(mobileMenuOpen){$dispatch(\'close-mobile-search\')};"',
        'x-on:close-mobile-menu.window="mobileMenuOpen = false"',
    ],
])
?>

                <!-- Logo -->
                <a href="/" class="logo w-60"><img src="<?php echo $logo_url; ?>" /></a>

                <!-- Right panel -->
                <div class="right-panel flex justify-between align-center font-bold"
                    x-bind:class=" searchOpen ? 'lg:flex-grow' : '' ">
                    <?php
    foreach ($secondary_nav_items as $secondary_nav_item) {
        $target = $secondary_nav_item->target ?? '';
        get_component('link', [
            'text'   => $secondary_nav_item->title,
            'target' => $target,
            'url'    => $secondary_nav_item->url,
            'atts'   => ['x-show="! searchOpen"', 'x-cloak'],
        ]);
    }
?>
                    <?php
if ($nav_state == 'logged_out') {
    if ($display_create_account_link) {
        get_component('button', [
            'variant'     => $create_account_button_style,
            'a_tag'       => true,
            'link_target' => $create_account_target_attr,
            'link'        => $create_account_url,
            'classes'     => ['create-account-button', 'hidden', 'md:inline-flex'],
            'label'       => $create_account_label,
            'atts'        => ['x-show="! searchOpen"', 'x-cloak'],
        ]);
    }
} elseif ($nav_state == 'logged_in_user') {
    if ($display_bam_link) {
        get_component('button', [
            'variant'     => $bam_button_style,
            'a_tag'       => true,
            'link'        => $bam_url,
            'classes'     => ['become-a-member-button', 'mr-4'],
            'label'       => $bam_label,
            'link_target' => $bam_target_attr,
            'atts'        => [' x-bind:class=" searchOpen ? \'hidden md:inline-flex lg:hidden\' : \'hidden md:inline-flex\' " '],
        ]);
    }
    get_component('button', [
        'variant' => 'secondary',
        'a_tag'   => true,
        'link'    => $account_center_landing,
        'classes' => ['my-account-button', 'hidden', 'lg:inline-flex'],
        'label'   => __('My Account', 'wicket'),
        'atts'    => ['x-show="! searchOpen"', 'x-cloak'],
    ]);
} elseif ($nav_state == 'logged_in_member') {
    get_component('button', [
        'variant' => 'secondary',
        'a_tag'   => true,
        'link'    => $account_center_landing,
        'classes' => ['member-portal-button', 'hidden', 'md:inline-flex'],
        'label'   => __('Member Portal', 'wicket'),
        'atts'    => ['x-show="! searchOpen"', 'x-cloak'],
    ]);
}
?>
                    <?php if ($nav_state == 'logged_out') : ?>
                        <?php
    get_component('button', [
        'variant' => 'ghost',
        'a_tag'   => true,
        'label'   => __('Login', 'wicket'),
        'classes' => ['login-button', 'mx-4', 'items-center', 'hidden', 'lg:inline-flex'],
        'link'    => get_option('wp_cassify_base_url') . 'login?service=' . $referrer,
        'atts'    => ['x-show="! searchOpen"', 'x-cloak'],
    ]);
                        ?>
                    <?php else : ?>
                        <?php
                        get_component('button', [
                            'variant' => 'ghost',
                            'a_tag'   => true,
                            'label'   => __('Logout', 'wicket'),
                            'classes' => ['logout-button', 'mx-4', 'items-center', 'hidden', 'lg:inline-flex'],
                            'link'    => wp_logout_url(),
                            'atts'    => ['x-show="! searchOpen"', 'x-cloak'],
                        ]);
                        ?>
                    <?php endif; ?>
                    <!-- Start search field -->
                    <div x-show="searchOpen" x-cloak class="hidden lg:block flex-grow px-2 ml-20">
                        <form class="flex" action="/" method="get">
                            <label for="search" class="hidden"><?php _e('Search the website', 'wicket'); ?></label>
                            <input class="w-full p-1" type="text" name="s" id="search"
                                value="<?php the_search_query(); ?>"
                                placeholder="<?php _e('Search by Keyword', 'wicket'); ?>" />
                            <?php get_component('button', [
                                'variant' => 'primary',
                                'type'    => 'submit',
                                'label'   => __('Search', 'wicket'),
                                'classes' => ['search-submit-button', 'ml-2', 'border-0'],
                            ]) ?>
                        </form>
                    </div>
                    <!-- End search field -->
                    <!-- Start search button states -->
                    <button x-on:click="searchOpen = ! searchOpen; if(searchOpen){$dispatch('close-mobile-menu')};"
                        x-on:close-mobile-search.window="searchOpen = false" x-show="showSearch" x-cloak
                        class="search-toggle-button mx-4">
                        <span x-show="! searchOpen" x-cloak>
                            <?php
                            get_component('icon', [
                                'classes' => [],
                                'icon'    => 'fa-solid fa-magnifying-glass',
                                'text'    => '',
                            ]);
?>
                        </span>
                        <span x-show="searchOpen" x-cloak>
                            <?php
get_component('icon', [
    'classes' => [],
    'icon'    => 'fa-solid fa-x',
    'text'    => '',
]);
?>
                        </span>
                    </button>
                    <!-- End search button states -->

                    <div class="relative flex">
                        <span class="cart-customlocation absolute top-[5px] right-[5px] bg-[--text-button-label] rounded-full text-white text-sm w-5 h-5 flex text-xs items-center justify-center no-underline">
                            <?php
if (class_exists('WooCommerce')) {
    echo WC()->cart->get_cart_contents_count();
}
?>
                        </span>
                        <?php get_component('button', [
                            'variant'     => 'ghost',
                            'link'        => $cart_path,
                            'a_tag'       => true,
                            'label'       => '',
                            'prefix_icon' => 'fa-regular fa-cart-shopping',
                            'atts'        => ['x-show="showCart"'],
                        ]) ?>
                    </div>

                    <div class="hidden lg:flex items-center">
                        <?php do_action('wpml_language_switcher'); ?>
                    </div>

                    <!-- Right-aligned hamburger menu button that only shows on MD breakpoint or below -->
                    <div class="relative">
                        <button
                            x-on:click="mobileMenuOpen = ! mobileMenuOpen; if(mobileMenuOpen){$dispatch('close-mobile-search')};"
                            x-on:close-mobile-menu.window="mobileMenuOpen = false" class="right-hamburger-button hidden md:inline-flex lg:hidden">
                            <span x-show="! mobileMenuOpen" x-cloak>
                                <?php
                                get_component('icon', [
                                    'classes' => ['text-x-large', 'lg:text-large', 'px-2'],
                                    'icon'    => 'fa-solid fa-bars',
                                    'text'    => '',
                                ]);
?>
                            </span>
                            <span x-show="mobileMenuOpen" x-cloak>
                                <?php
                                get_component('icon', [
                                    'classes' => ['text-x-large', 'lg:text-large', 'bg-dark-040', 'rounded-base', 'px-2', 'py-0'],
                                    'icon'    => 'fa-solid fa-x',
                                    'text'    => '',
                                ]);
?>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div> <!-- End secondary nav -->

        <!-- Main Nav Desktop -->
        <nav x-ref="main-nav" class="main-nav">
            <ul class="main-nav__list container w-full gap-4 hidden lg:flex relative <?php if (count($primary_nav_items_structured) > 4) {
                echo 'justify-between';
            } else {
                echo 'justify-evenly';
            } ?>">
                <?php
                foreach ($primary_nav_items_structured as $primary_nav_item) :
                    $is_primary_nav_item_last_item = ($primary_nav_item == end($primary_nav_items_structured)) ? true : false;
                    // If this is a single menu item link
                    if ($primary_nav_item['child_count'] == 0) :
                        ?>
                        <li class="main-nav__single-menu-item">
                            <?php
                                    $target = $primary_nav_item['target'] ?? '';
                        get_component('link', [
                            'text'    => $primary_nav_item['title'],
                            'classes' => ['!items-baseline'],
                            'target'  => $target,
                            'url'     => $primary_nav_item['url'],
                        ]);
                        ?>
                        </li>

                    <?php
                        // If this menu item only has immediate children AND has item count <= 8
                    elseif ($primary_nav_item['child_count'] > 0 && $primary_nav_item['child_count'] <= 8 && $primary_nav_item['grand_child_count'] == 0) :
                        ?>
                        <!-- Start Nav Item -->
                        <li class="main-nav__dropdown-menu-item" :class="navDropdownOpen ? 'open' : ''"
                            x-data="{ navDropdownOpen: false }"
                            x-on:click="navDropdownOpen = ! navDropdownOpen; $dispatch('close-nav-dropdowns')" <?php // If the sending element isn't this element, close dropdown
                                                                                                                    ?> x-on:close-nav-dropdowns.window="
					if( $event.target !== $el ) {navDropdownOpen = false}">
                            <span><?php echo $primary_nav_item['title']; ?></span><i class="fa-solid fa-caret-down ml-2"></i>

                            <ul x-show="navDropdownOpen" x-cloak x-transition
                                class="nav-dropdown <?php echo $is_primary_nav_item_last_item ? 'last' : '' ?>">
                                <?php
                                    $child_loop_index = 0;
                        foreach ($primary_nav_item['children'] as $child) :
                            // If this is the last element in the list
                            $is_last_element = $child_loop_index == (count($primary_nav_item['children']) - 1);
                            ?>
                                    <li class="<?php if (!$is_last_element) {
                                        echo 'mb-4';
                                    } ?>">
                                        <?php
                                        $target = $child['target'] ?? '';
                            get_component('link', [
                                'text'    => $child['title'],
                                'classes' => $child['classes'],
                                'target'  => $target,
                                'url'     => $child['url'],
                            ]);
                            ?>
                                    </li>
                                <?php
                                    $child_loop_index++;
                        endforeach; ?>
                            </ul>
                        </li> <!-- End Nav Item -->


                    <?php
                        // MEGA MENU If this menu item has grand children OR has more than 8 items
                    elseif ($primary_nav_item['child_count'] > 8 || $primary_nav_item['grand_child_count'] > 0) :
                        ?>
                        <!-- Start Nav Item -->
                        <li class="main-nav__mega-menu-item" x-data="{ navDropdownOpen: false }"
                            :class="navDropdownOpen ? 'open' : ''"
                            x-on:click="navDropdownOpen = ! navDropdownOpen; $dispatch('close-nav-dropdowns')" <?php // If the sending element isn't this element, close dropdown
                                                                                                                    ?> x-on:close-nav-dropdowns.window="
					if( $event.target !== $el ) {navDropdownOpen = false}">
                            <span><?php echo $primary_nav_item['title']; ?></span><i class="fa-solid fa-caret-down ml-2"></i>

                            <div x-show="navDropdownOpen" x-cloak x-transition class="nav-mega-dropdown container">
                                <?php
                                    foreach ($primary_nav_item['children'] as $child) :
                                        // Just print these as a header if there are no children
                                        if ($child['child_count'] == 0) :
                                            ?>
                                        <div>
                                            <?php
                                                        $target = $child['target'] ?? '';
                                            get_component('link', [
                                                'text'    => $child['title'],
                                                'classes' => ['desktop-mega-menu-heading-item'],
                                                'target'  => $target,
                                                'url'     => $child['url'],
                                            ]);
                                            ?>
                                        </div>
                                    <?php else : ?>
                                        <div>
                                            <?php
                                            $target = $child['target'] ?? '';
                                        get_component('link', [
                                            'text'    => $child['title'],
                                            'classes' => ['desktop-mega-menu-heading-item'],
                                            'target'  => $target,
                                            'url'     => $child['url'],
                                        ]);
                                        ?>
                                            <ul>
                                                <?php foreach ($child['children'] as $grand_child) : ?>
                                                    <li class="mb-4">
                                                        <?php
                                                    $target = $grand_child['target'] ?? '';
                                                    get_component('link', [
                                                        'text'    => $grand_child['title'],
                                                        'classes' => $grand_child['classes'],
                                                        'target'  => $target,
                                                        'url'     => $grand_child['url'],
                                                    ]);
                                                    ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div> <!-- End Mega Menu -->
                        </li> <!-- End Nav Item -->
                <?php
                    endif;
                endforeach; // End main nav looping
?>

            </ul>
        </nav> <!-- End main nav -->

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-cloak x-transition x-anchor.bottom-start="$refs.secondary-nav"
            class="mobile-menu-container w-full bg-[--bg-white] font-bold">
            <div class="pt-3 pb-2 px-3 text-center">
                <?php
// Conditional Account Buttons
if ($nav_state == 'logged_out') {
    if ($display_create_account_link) {
        get_component('button', [
            'variant'     => $create_account_button_style,
            'a_tag'       => true,
            'link'        => $create_account_url,
            'link_target' => $create_account_target_attr,
            'classes'     => ['create-account-button-mobile', 'w-full', 'mb-3', 'justify-center', 'md:hidden'],
            'label'       => $create_account_label,
        ]);
    }
} elseif ($nav_state == 'logged_in_user') {
    if ($display_bam_link) {
        get_component('button', [
            'variant'     => $bam_button_style,
            'a_tag'       => true,
            'link'        => $bam_url,
            'link_target' => $bam_target_attr,
            'classes'     => ['become-a-member-button-mobile', 'w-full', 'mb-3', 'justify-center', 'md:hidden'],
            'label'       => $bam_label,
        ]);
    }
    get_component('button', [
        'variant' => 'secondary',
        'a_tag'   => true,
        'link'    => $account_center_landing,
        'classes' => ['my-account-button-mobile', 'w-full', 'mb-3', 'justify-center'],
        'label'   => __('My Account', 'wicket'),
    ]);
} elseif ($nav_state == 'logged_in_member') {
    get_component('button', [
        'variant' => 'secondary',
        'a_tag'   => true,
        'link'    => $account_center_landing,
        'classes' => ['member-portal-button-mobile', 'w-full', 'mb-3', 'justify-center'],
        'label'   => __('Member Portal', 'wicket'),
    ]);
}
?>
                <?php
// Conditional login/logout buttons
if ($nav_state == 'logged_out') {
    get_component('button', [
        'label'   => __('Login', 'wicket'),
        'variant' => 'ghost',
        'a_tag'   => true,
        'classes' => ['login-button-mobile', 'mb-2', 'w-full', 'justify-center'],
        'link'    => get_option('wp_cassify_base_url') . 'login?service=' . $referrer,
    ]);
} else {
    get_component('button', [
        'label'   => __('Logout', 'wicket'),
        'variant' => 'ghost',
        'a_tag'   => true,
        'classes' => ['logout-button-mobile', 'mb-2', 'w-full', 'justify-center'],
        'link'    => wp_logout_url(),
    ]);
}
?>
            </div> <!-- End items above main nav items and utility nav -->

            <div class="main-nav-mobile">
                <?php
// Loop main nav items
foreach ($primary_nav_items_structured as $primary_nav_item) :
    // If this is a single menu item link
    if ($primary_nav_item['child_count'] == 0) :
        ?>
                        <?php
                $target = $primary_nav_item['target'] ?? '';
        get_component('link', [
            'text'    => $primary_nav_item['title'],
            'classes' => ['single-nav-item-mobile'],
            'target'  => $target,
            'url'     => $primary_nav_item['url'],
        ]);
        ?>

                    <?php
        // If this menu item only has immediate children AND has item count <= 8
    elseif ($primary_nav_item['child_count'] > 0 && $primary_nav_item['child_count'] <= 8 && $primary_nav_item['grand_child_count'] == 0) :
        ?>
                        <!-- Start Nav Item -->
                        <div class="nav-parent-item-mobile" :class="navDropdownOpen ? 'open' : ''"
                            x-data="{ navDropdownOpen: false }"
                            x-on:click="navDropdownOpen = ! navDropdownOpen; $dispatch('close-nav-dropdowns')" <?php // If the sending element isn't this element, close dropdown
                                                                                                    ?> x-on:close-nav-dropdowns.window="
					if( $event.target !== $el ) {navDropdownOpen = false}">
                            <div class="nav-parent-item-mobile-wrap" x-bind:class=" navDropdownOpen ? 'open' : '' ">
                                <span><?php echo $primary_nav_item['title']; ?></span>
                                <i x-show="! navDropdownOpen" x-cloak class="fa-solid fa-caret-down"></i>
                                <i x-show="navDropdownOpen" x-cloak class="fa-solid fa-caret-up"></i>
                            </div>

                            <ul x-show="navDropdownOpen" x-cloak x-transition class="nav-dropdown-mobile block w-full p-3">
                                <?php
                    $child_loop_index = 0;
        foreach ($primary_nav_item['children'] as $child) :
            // If this is the last element in the list
            $is_last_element = $child_loop_index == (count($primary_nav_item['children']) - 1);
            ?>
                                    <li class="<?php if (!$is_last_element) {
                                        echo 'mb-4';
                                    } ?>">
                                        <?php
                                        $target = $child['target'] ?? '';
            get_component('link', [
                'text'    => $child['title'],
                'classes' => $child['classes'],
                'target'  => $target,
                'url'     => $child['url'],
            ]);
            ?>
                                    </li>
                                <?php
                                    $child_loop_index++;
        endforeach; ?>
                            </ul>
                        </div> <!-- End Nav Item -->


                    <?php
        // MEGA MENU If this menu item has grand children OR has more than 8 items
    elseif ($primary_nav_item['child_count'] > 8 || $primary_nav_item['grand_child_count'] > 0) :
        ?>

                        <!-- Start Nav Item -->
                        <div class="nav-mega-parent-item-mobile" x-data="{ navDropdownOpen: false }"
                            x-on:click="navDropdownOpen = ! navDropdownOpen; $dispatch('close-nav-dropdowns')" <?php // If the sending element isn't this element, close dropdown
                                                                                                    ?> x-on:close-nav-dropdowns.window="
					if( $event.target !== $el ) {navDropdownOpen = false}">
                            <div class="nav-mega-parent-item-mobile-wrap" x-bind:class=" navDropdownOpen ? 'open' : '' ">
                                <span><?php echo $primary_nav_item['title']; ?></span>
                                <i x-show="! navDropdownOpen" x-cloak class="fa-solid fa-caret-down"></i>
                                <i x-show="navDropdownOpen" x-cloak class="fa-solid fa-caret-up"></i>
                            </div>

                            <ul x-show="navDropdownOpen" x-cloak x-transition
                                class="nav-dropdown-mobile block w-full bg-[--bg-white]">
                                <?php
                    foreach ($primary_nav_item['children'] as $child) :
                        // Just print these as a header if there are no children
                        if ($child['child_count'] == 0) :

                            $target = $child['target'] ?? '';
                            get_component('link', [
                                'text'    => $child['title'],
                                'classes' => ['block', 'p-3', 'border-dark-060', 'font-bold', 'border-b-medium', 'border-dark-100'],
                                'target'  => $target,
                                'url'     => $child['url'],
                            ]);
                            ?>

                                    <?php else : ?>
                                        <div class="flex flex-col w-full relative hover:cursor-pointer"
                                            x-data="{ subNavDropdownOpen: false }" <?php // Note: .stop prevents this click event from propagating/bubbling up to the parent dropdown; see https://alpinejs.dev/directives/on#stop
                                                                                ?>
                                            x-on:click.stop="if(mobileMenuMegaSubDropdowns) {subNavDropdownOpen = ! subNavDropdownOpen;} $dispatch('close-sub-nav-dropdowns')"
                                            <?php // If the sending element isn't this element, close dropdown
                                        ?>
                                            x-on:close-sub-nav-dropdowns.window="if( $event.target !== $el ) {subNavDropdownOpen = false}">
                                            <div class="mobile-mega-menu-heading-item" x-bind:class=" subNavDropdownOpen ? '' : '' ">
                                                <span><?php echo $child['title']; ?></span>
                                                <i x-show="! subNavDropdownOpen && mobileMenuMegaSubDropdowns" x-cloak
                                                    class="fa-solid fa-caret-down"></i>
                                                <i x-show="subNavDropdownOpen && mobileMenuMegaSubDropdowns" x-cloak
                                                    class="fa-solid fa-caret-up"></i>
                                            </div>

                                            <ul x-show="subNavDropdownOpen || !mobileMenuMegaSubDropdowns" x-cloak x-transition
                                                class="block w-full p-3">
                                                <?php
                                            $child_loop_index = 0;
                                        foreach ($child['children'] as $grand_child) :
                                            // If this is the last element in the list
                                            $is_last_element = $child_loop_index == (count($child['children']) - 1);
                                            ?>
                                                    <li class="<?php if (!$is_last_element) {
                                                        echo 'mb-4';
                                                    } ?>">
                                                        <?php
                                                        $target = $grand_child['target'] ?? '';
                                            get_component('link', [
                                                'text'    => $grand_child['title'],
                                                'classes' => [],
                                                'target'  => $target,
                                                'url'     => $grand_child['url'],
                                            ]);
                                            ?>
                                                    </li>
                                                <?php
                                                    $child_loop_index++;
                                        endforeach; ?>
                                            </ul>
                                        </div>
                                <?php endif;
                    endforeach; ?>
                            </ul>
                        </div> <!-- End Nav Item -->
                <?php
                    endif;
endforeach; // End main nav looping
?>
            </div>

            <div class="secondary-nav-mobile">
                <?php
// Secondary Nav Items
foreach ($secondary_nav_items as $secondary_nav_item) {
    $target = $secondary_nav_item->target ?? '';
    get_component('link', [
        'text'    => $secondary_nav_item->title,
        'classes' => ['secondary-nav-item-mobile', 'block', 'mb-2'],
        'target'  => $target,
        'url'     => $secondary_nav_item->url,
    ]);
}
?>

                <div class="secondary-nav-item-mobile-wpml">
                    <?php do_action('wpml_language_switcher'); ?>
                </div>
            </div>

            <?php if (!empty($utility_nav_items)) : ?>
                <div class="utility-nav-mobile">
                    <?php
    // Utility Nav Items
    foreach ($utility_nav_items as $utility_nav_item) {
        $target = $utility_nav_item->target ?? '';
        get_component('link', [
            'text'    => $utility_nav_item->title,
            'classes' => ['utility-nav-mobile__item'],
            'target'  => $target,
            'url'     => $utility_nav_item->url,
        ]);
    }
                ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- Mobile Search -->
        <div x-show="searchOpen" x-cloak x-transition x-anchor.bottom-start="$refs.secondary-nav"
            class="search-bar-mobile">
            <form class="flex" action="/" method="get">
                <label for="search" class="hidden"><?php _e('Search the website', 'wicket'); ?></label>
                <input class="w-full" type="text" name="s" id="search" value="<?php the_search_query(); ?>"
                    placeholder="<?php _e('Search by Keyword', 'wicket'); ?>" />
                <?php get_component('button', [
                    'variant' => 'primary',
                    'type'    => 'submit',
                    'label'   => __('Search', 'wicket'),
                    'classes' => ['ml-2', 'border-0'],
                ]) ?>
            </form>
        </div>

    </header>

    <?php
    /* Conditionally-rendered helpers: */

    $wicket_helpers_current_user = wp_get_current_user();
$wicket_is_administrator = false;
if (in_array('administrator', (array) $wicket_helpers_current_user->roles)) {
    $wicket_is_administrator = true;
}
?>

    <?php if (isset($_GET['wp-info']) && $wicket_is_administrator) : ?>
        <div class="fixed block bottom-0 left-0 bg-[--bg-white] border text-dark-100 p-2">
            <div><strong>Post type:</strong>
                <?php echo get_post_type(); ?>
            </div>
            <?php
        $wicket_helper_current_template = get_page_template_slug();
        if (empty($wicket_helper_current_template)) {
            $wicket_helper_current_template = 'Default';
        }
        ?>
            <div><strong>Current template:</strong>
                <?php echo $wicket_helper_current_template; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php do_action('wicket_header_end'); ?>
