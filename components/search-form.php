<?php
$defaults    = array(
	'classes'     => [ 'flex', 'gap-2', 'w-full' ],
	'placeholder' => __( 'Search by Keyword', 'wicket' ),
);
$args        = wp_parse_args( $args, $defaults );
$classes     = $args['classes'];
$placeholder = $args['placeholder'];
?>

<form role="search" method="get" class="<?php echo implode( ' ', $classes ); ?>">
	<div class="relative w-full">
		<?php get_component( 'icon', [ 
			'icon'    => 'fa fa-search',
			'text'    => __( 'Search' ),
			'classes' => [ 
				'absolute',
				'left-4',
				'top-1/2',
				'-translate-y-1/2',
				'text-dark-100',
				'text-lg',
			],
		] ); ?>
		<input type="search" id="s" name="s" value="<?php echo get_search_query(); ?>"
			placeholder="<?php echo $placeholder; ?>" class="pl-10 w-full" />
	</div>

	<?php get_component( 'button', [ 
		'variant' => 'primary',
		'label'   => __( 'Search', 'wicket' ),
	] ) ?>
</form>