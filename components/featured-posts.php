<?php
$defaults            = array(
	'classes'             => [ 'px-4', 'lg:px-0' ],
	'title'               => __( 'Featured', 'wicket' ),
	'hide_block_title'    => false,
	'posts'               => [],
	'hide_excerpt'        => false,
	'hide_date'           => false,
	'hide_featured_image' => false,
	'hide_content_type'   => false,
	'style'               => 'primary-secondary-level',
	'column_count'        => 3,
);
$args                = wp_parse_args( $args, $defaults );
$classes             = $args['classes'];
$title               = $args['title'];
$posts               = $args['posts'];
$hide_excerpt        = $args['hide_excerpt'];
$hide_date           = $args['hide_date'];
$hide_featured_image = $args['hide_featured_image'];
$hide_content_type   = $args['hide_content_type'];
$style               = $args['style'];
$column_count        = $args['column_count'];
$classes[]           = 'component-featured-posts';
?>

<div class="<?php echo implode( ' ', $classes ) ?>">

	<?php if ( $title ) : ?>
		<div class="text-heading-sm font-bold <?php echo $style === 'primary-secondary-level' ? 'mb-4' : 'mb-10' ?>">
			<?php echo $title; ?>
		</div>
	<?php endif; ?>

	<?php if ( $style === 'primary-secondary-level' ) : ?>
		<div class="flex flex-col gap-10 lg:flex-row lg:gap-4">
			<div class="flex-1 lg:basis-5/12">
				<?php
				$post         = $posts[0];
				$post_id      = $post->ID;
				$image        = [];
				$content_type = get_the_terms( $post_id, 'content_type' );
				$post_date    = get_the_date( 'F j, Y', $post_id );

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
					'content_type'   => ! $hide_content_type ? $content_type[0]->name : '',
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
					$post_id      = $post->ID;
					$post_date    = get_the_date( 'F j, Y', $post_id );
					$image        = [];
					$content_type = get_the_terms( $post_id, 'content_type' );
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
						'content_type'   => ! $hide_content_type ? $content_type[0]->name : '',
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

	<?php if ( $style === 'one-level' ) : ?>
		<div class="grid gap-4 grid-cols-1 lg:grid-cols-<?php echo $column_count ?>">
			<?php
			foreach ( $posts as $post ) {
				$post_id              = $post->ID;
				$post_date            = get_the_date( 'F j, Y', $post_id );
				$related_content_type = get_related_content_type( $post->post_type );
				$content_type         = ! is_wp_error( get_the_terms( $post_id, $related_content_type ) ) ? get_the_terms( $post_id, $related_content_type ) : [];
				$image                = [];
				if ( ! $hide_featured_image ) {
					$featured_image_id  = get_post_thumbnail_id( $post_id );
					$featured_image_alt = get_post_meta( $featured_image_id, '_wp_attachment_image_alt', true );
					$image              = $featured_image_id === 0 ? [] : [ 
						'id'  => $featured_image_id,
						'alt' => $featured_image_alt,
					];
				}

				get_component( 'card-featured', [ 
					'classes'      => [ 'p-4' ],
					'title'        => get_the_title( $post_id ),
					'excerpt'      => ! $hide_excerpt ? get_the_excerpt( $post_id ) : '',
					'image'        => $image,
					'content_type' => ( ! $content_type['errors'] && ! $hide_content_type ) ? $content_type[0]->name : '',
					'date'         => ! $hide_date ? $post_date : '',
					'member_only'  => is_member_only( $post_id ),
					'link'         => get_permalink( $post_id ),
				] );
			}
			?>
		</div>
	<?php endif; ?>

</div>