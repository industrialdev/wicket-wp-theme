<?php

// Register widget areas
function wicket_widgets_init()
{
    register_sidebar([
        'id'          => 'sidebar-widgets',
        'name'        => _x('Sidebar Widgets', 'widget area name', 'wicket-theme'),
        'description' => __('Sidebar widget area.', 'wicket-theme'),
    ]);
}
add_action('widgets_init', 'wicket_widgets_init');
