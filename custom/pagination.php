<?php

// Prevent WordPress from rewriting ?paged=N to /page/N/ on singular Pages.
// The Wicket listing block renders a custom WP_Query on Pages; pretty
// /page/N/ URLs 404 there because WP treats them as singular nextpage
// pagination. The listing block emits query-string pagination links, and
// this filter keeps those URLs intact instead of redirecting them to a 404.
add_filter('redirect_canonical', function ($redirect_url) {
    if (is_singular() && ! is_home() && (int) get_query_var('paged') > 1) {
        return false;
    }

    return $redirect_url;
});

if (!function_exists('wicket_paginate_links')) {

    function wicket_paginate_links($args = [])
    {

        global $wp_query;

        $current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $total_pages = $wp_query->max_num_pages ?? 1;

        // default args
        $args = wp_parse_args(
            $args,
            [
                'total'     => $total_pages,
                'current'   => $current_page,
                'type'      => 'array',
                'next_text' => __('Next', 'wicket') . ' <i class="fa fa-arrow-right ml-[--space-100]" aria-hidden="true"></i>',
                'prev_text' => '<i class="fa fa-arrow-left mr-[--space-100]" aria-hidden="true"></i> ' . __('Previous', 'wicket'),
            ]
        );
        $total_pages = (int) $args['total'];
        $current_page = (int) $args['current'];
        $orig_type = $args['type'];

        $page_links = paginate_links($args);

        if (!$page_links) {
            return false;
        }

        $r = '';
        switch ($orig_type) {
            case 'array':
                $r = implode("\n", $page_links);
                // no break
            default:
                $r = implode("\n", $page_links);
                break;
        }

        return $r;
    }
}

if (!function_exists('wicket_pagination')) {

    function wicket_pagination($args = [])
    {

        return '<nav class="wicket-pagination" aria-label="' . __('Pagination', 'wicket') . '">' . wicket_paginate_links($args) . '</nav>';

    }
}

if (!function_exists('the_wicket_pagination')) {

    function the_wicket_pagination($args = [])
    {

        echo wicket_pagination($args);

    }
}
