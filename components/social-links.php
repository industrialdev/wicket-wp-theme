<?php
$defaults = array(
	'classes'  => [],
	'reversed' => false,
);

$args     = wp_parse_args( $args, $defaults );
$classes  = $args['classes'];
$reversed = $args['reversed'];
$classes[] = 'flex gap-2 list-none p-0 m-0 items-center';

if ( have_rows( 'social_media_links', 'option' ) ) : ?>
	<ul class="<?php echo implode( ' ', $classes ) ?>">
		<?php while ( have_rows( 'social_media_links', 'option' ) ) :
			the_row(); ?>
			<li>
				<?php get_component( 'button', [ 
					'size'               => 'sm',
					'variant'            => 'primary',
					'label'              => '',
					'prefix_icon'        => 'fab fa-' . get_row_layout() . ' fa-fw',
					'reversed'           => $reversed,
					'rounded'            => true,
					'a_tag'              => true,
					'link'               => get_sub_field( 'link' ),
					'link_target'        => '_blank',
					'screen_reader_text' => 'Follow us on ' . get_sub_field( 'link' ),
				] ) ?>
			</li>
		<?php endwhile; ?>
	</ul>
<?php endif; ?>