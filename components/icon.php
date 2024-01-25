<?php
$defaults  = array(
	'classes' => [],
	'icon'    => 'fa fa-default-icon', // Replace with your Font Awesome icon classes
	'text'    => '',
);
$args      = wp_parse_args( $args, $defaults );
$classes   = $args['classes'];
$icon      = $args['icon'];
$text      = $args['text'];
$classes[] = 'icon';
?>

<span class="<?php echo implode( ' ', $classes ) ?>">
	<i class="<?php echo $icon; ?>" aria-hidden="true"></i>
	<span class="sr-only">
		<?php echo $text; ?>
	</span>
</span>