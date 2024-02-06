<?php
$defaults            = array(
	'classes'             => [ 'px-4', 'lg:px-0' ],
	'title'               => __( 'Featured', 'wicket' ),
	'hide_block_title'    => false,
	'posts'               => [],
	'hide_date'           => false,
	'hide_featured_image' => false,
	'hide_content_type'   => false,
	'style'               => 'one-level',
	'column_count'        => 3,
);
$args                = wp_parse_args( $args, $defaults );
$classes             = $args['classes'];
$title               = $args['title'];
$posts               = $args['posts'];
$hide_date           = $args['hide_date'];
$hide_featured_image = $args['hide_featured_image'];
$hide_content_type   = $args['hide_content_type'];
$style               = $args['style'];
$column_count        = $args['column_count'];
?>

<div class="<?php echo implode( ' ', $classes ) ?>">

	<?php if ( $title ) : ?>
		<div class="text-heading-sm font-bold mb-3">
			<?php echo $title; ?>
		</div>
	<?php endif; ?>

	<?php if ( $style === 'one-level' ) : ?>
		<div class="flex flex-col gap-10 lg:flex-row lg:gap-4">
			<div class="flex-1 lg:basis-5/12">
				<?php
				$post      = $posts[0];
				$post_id   = $post->ID;
				$image     = [];
				$post_date = get_the_date( 'F j, Y', $post_id );

				if ( ! $hide_featured_image ) {
					$featured_image_id  = get_post_thumbnail_id( $post_id );
					$featured_image_alt = get_post_meta( $featured_image_id,
						'_wp_attachment_image_alt', true );
					$image              = [ 
						'id'  => $featured_image_id,
						'alt' => $featured_image_alt,
					];
				}

				get_component( 'card-featured', [ 
					'classes'        => [ 'p-4' ],
					'title'          => get_the_title( $post_id ),
					'image'          => $image,
					'image_position' => 'top',
					'content_type'   => ! $hide_content_type ? get_post_type( $post_id ) : '',
					'date'           => ! $hide_date ? $post_date : '',
					'member_only'    => is_member_only( $post_id ),
					'link'           => get_permalink( $post_id ),
				] ); ?>
			</div>
			<div class="flex-1 lg:basis-7/12">
				<?php
				$posts = array_slice( $posts, 1 );
				$index = 0;
				foreach ( $posts as $post ) {
					$index++;
					$post_id   = $post->ID;
					$post_date = get_the_date( 'F j, Y', $post_id );
					$image     = [];
					if ( ! $hide_featured_image ) {
						$featured_image_id  = get_post_thumbnail_id( $post_id );
						$featured_image_alt = get_post_meta( $featured_image_id, '_wp_attachment_image_alt', true );
						$image              = [ 
							'id'  => $featured_image_id,
							'alt' => $featured_image_alt,
						];
					}
					get_component( 'card-featured', [ 
						'classes'        => [ 'shadow-none' ],
						'title'          => get_the_title( $post_id ),
						'image'          => $image,
						'image_position' => 'right',
						'content_type'   => ! $hide_content_type ? get_post_type( $post_id ) : '',
						'date'           => ! $hide_date ? $post_date : '',
						'member_only'    => is_member_only( $post_id ),
						'link'           => get_permalink( $post_id ),
					] );

					if ( $index < count( $posts ) ) {
						echo '<hr class="border-t border-light-020 my-4">';
					}
				}
				?>
			</div>
		</div>
	<?php endif; ?>

</div>