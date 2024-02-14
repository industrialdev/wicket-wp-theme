<?php
$defaults = array(
	'classes'  => [],
	'reversed' => false,
);

$args     = wp_parse_args( $args, $defaults );
$classes  = $args['classes'];
$reversed = $args['reversed'];

$classes[] = 'component-social-sharing flex gap-2 list-none p-0 m-0 items-center';
?>

<ul class="<?php echo implode( ' ', $args['classes'] ) ?>">
	<li class="font-bold <?php echo $reversed ? 'text-white' : '' ?>">
		<?php _e( 'Share', 'wicket' ) ?>
	</li>
	<li>
		<?php get_component( 'button', [ 
			'size'        => 'sm',
			'variant'     => 'ghost',
			'label'       => '',
			'prefix_icon' => 'fab fa-facebook-f fa-fw',
			'reversed'    => $reversed,
			'rounded'     => true,
			'a_tag'       => true,
			'link'        => 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink(),
			'link_target' => '_blank',
		] ) ?>
	</li>
	<li>
		<?php get_component( 'button', [ 
			'size'        => 'sm',
			'variant'     => 'ghost',
			'label'       => '',
			'prefix_icon' => 'fab fa-x-twitter fa-fw',
			'reversed'    => $reversed,
			'rounded'     => true,
			'a_tag'       => true,
			'link'        => 'https://twitter.com/intent/tweet?url=' . get_the_permalink() . '&amp;text=' . urlencode( get_the_title() ) . '%20-%20' . urlencode( get_the_excerpt() ),
			'link_target' => '_blank',
		] ) ?>
	</li>
	<li>
		<?php get_component( 'button', [ 
			'size'        => 'sm',
			'variant'     => 'ghost',
			'label'       => '',
			'prefix_icon' => 'fab fa-linkedin-in fa-fw',
			'reversed'    => $reversed,
			'rounded'     => true,
			'a_tag'       => true,
			'link'        => 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . get_the_permalink() . '&amp;title=' . urlencode( get_the_title() ),
			'link_target' => '_blank',
		] ) ?>
	</li>
	<li>
		<?php get_component( 'button', [ 
			'size'        => 'sm',
			'variant'     => 'ghost',
			'label'       => '',
			'prefix_icon' => 'fas fa-envelope fa-fw',
			'reversed'    => $reversed,
			'rounded'     => true,
			'a_tag'       => true,
			'link'        => 'mailto:?subject=' . urlencode( get_the_title() ) . '&body=' . get_the_permalink(),
			'link_target' => '_blank',
		] ) ?>
	</li>
</ul>