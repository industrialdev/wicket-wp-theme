<?php
$defaults  = array(
	'classes'          => [ 'px-4', 'py-10', 'lg:px-0', 'bg-light-010' ],
	'title'            => __( 'Related ', 'wicket' ),
	'hide_block_title' => false,
	'posts'            => [],
	'post_type'        => 'post',
);
$args      = wp_parse_args( $args, $defaults );
$classes   = $args['classes'];
$title     = $args['title'];
$posts     = $args['posts'];
$post_type = $args['post_type'];

// Get post type plural label
$post_type_object = get_post_type_object( $post_type );
$post_type_label  = $post_type_object->labels->name;

// Get post type archive link
$post_type_archive_link = get_post_type_archive_link( $post_type );

$classes[] = 'component-related-posts';
?>

<div class="<?php echo implode( ' ', $classes ) ?>">
	<div class="container">
		<?php if ( $title ) : ?>
			<div class=" mb-12">
				<span class="text-heading-sm font-bold">
					<?php echo $title; ?>
					<?php echo $post_type_label; ?>
				</span>
				<a href="<?php echo $post_type_archive_link ?>" class="underline ml-4 pl-4 border-l border-dark-070">
					<?php echo __( 'View All', 'wicket' ) ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="grid gap-4 grid-cols-1 lg:grid-cols-3">
			<?php
			foreach ( $posts as $post ) {
				$post_id   = $post->ID;
				$post_date = get_the_date( 'F j, Y', $post_id );

				get_component( 'card-listing', [ 
					'title'        => get_the_title( $post_id ),
					'content_type' => get_post_type( $post_id ),
					'date'         => $post_date,
					'member_only'  => is_member_only( $post_id ),
					'link'         => [ 
						'url'    => get_permalink( $post_id ),
						'target' => '',
					],
				] );
			}
			?>
		</div>
	</div>
</div>