<?php
$defaults            = array(
	'classes'             => [ 'px-4', 'py-10', 'lg:px-0', 'bg-light-010' ],
	'title'               => '',
	'hide_block_title'    => false,
	'column_count'        => 3,
	'max_posts'           => 3,
	'post_type'           => [],
	'taxonomies'          => [],
	'hide_excerpt'        => false,
	'hide_date'           => false,
	'hide_featured_image' => false,
	'hide_content_type'   => false,
	'show_cta'            => false,
	'show_view_all'       => false,
	'cta_style'           => 'primary',
	'cta_label'           => '',
	'current_post_id'     => '',
);
$args                = wp_parse_args( $args, $defaults );
$classes             = $args['classes'];
$title               = $args['title'];
$hide_block_title    = $args['hide_block_title'];
$column_count        = $args['column_count'];
$max_posts           = $args['max_posts'];
$post_type           = $args['post_type'];
$taxonomies          = $args['taxonomies'];
$hide_excerpt        = $args['hide_excerpt'];
$hide_date           = $args['hide_date'];
$hide_featured_image = $args['hide_featured_image'];
$hide_content_type   = $args['hide_content_type'];
$show_cta            = $args['show_cta'];
$show_view_all       = $args['show_view_all'];
$cta_style           = $args['cta_style'];
$cta_label           = $args['cta_label'];
$current_post_id     = $args['current_post_id'];

if ( $title == '' ) {
	$post_type_object = get_post_type_object( $post_type['post_type'] );
	$post_type_label  = $post_type_object->labels->name;
	$title            = __( 'Related ', 'wicket' );
	$title .= $post_type_label;
}

// WP_Query arguments
$query_args = array(
	'post_type'      => $post_type,
	'posts_per_page' => $max_posts,
	'post__not_in'   => [ $current_post_id ],
);

// If taxonomies are set, add them to the query
if ( ! empty( $taxonomies ) ) {
	foreach ( $taxonomies as $taxonomy ) {
		$taxonomy_terms = isset( $taxonomy['taxonomy_terms'] ) ? $taxonomy['taxonomy_terms'] : '';
		$relation       = isset( $taxonomy['relation'] ) ? $taxonomy['relation'] : '';

		// Get taxonomy slug from taxonomy_term
		$relation_args             = array();
		$relation_args['relation'] = $relation;
		foreach ( $taxonomy_terms as $term ) {
			$term_object     = get_term( $term['taxonomy_term'] );
			$relation_args[] = array(
				'taxonomy' => $term_object->taxonomy,
				'field'    => 'slug',
				'terms'    => [ $term_object->slug ],
				'operator' => 'IN',
			);
		}

		// Add tax_query to query_args
		$query_args['tax_query'] = $relation_args;
	}
}

// The Query
$related_posts = new WP_Query( $query_args );

// Get post type archive link
$post_type_archive_link = get_post_type_archive_link( $post_type );

$classes[] = 'component-related-posts';
?>

<div class="<?php echo implode( ' ', $classes ) ?>">
	<div class="container">
		<?php if ( $title && ! $hide_block_title ) : ?>
			<div class=" mb-12">
				<span class="text-heading-sm font-bold">
					<?php echo $title; ?>
				</span>

				<?php if ( $show_view_all ) : ?>
					<a href="<?php echo $post_type_archive_link ?>" class="underline ml-4 pl-4 border-l border-dark-070">
						<?php echo __( 'View All', 'wicket' ) ?>
					</a>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<div class="grid gap-4 grid-cols-1 lg:grid-cols-<?php echo $column_count ?>">
			<?php

			if ( $related_posts->have_posts() ) {
				while ( $related_posts->have_posts() ) {
					$related_posts->the_post();
					$post_id              = get_the_ID();
					$image                = [];
					$related_content_type = get_related_content_type( get_post_type( $post_id ) );
					$content_type         = ! is_wp_error( get_the_terms( $post_id, $related_content_type ) ) ? get_the_terms( $post_id, $related_content_type ) : [];

					$featured_image_id  = get_post_thumbnail_id( $post_id );
					$featured_image_alt = get_post_meta( $featured_image_id,
						'_wp_attachment_image_alt', true );

					if ( ! $hide_featured_image && $featured_image_id !== 0 ) {
						$image = [ 
							'id'  => $featured_image_id,
							'alt' => $featured_image_alt,
						];
					}

					get_component( 'card-featured', [ 
						'classes'        => [ 'p-4' ],
						'content_type'   => ! $hide_content_type ? $content_type[0]->name : '',
						'title'          => get_the_title( $post_id ),
						'excerpt'        => ! $hide_excerpt ? get_the_excerpt( $post_id ) : '',
						'date'           => ! $hide_date ? get_the_date( 'F j, Y', $post_id ) : '',
						'image'          => $image,
						'image_position' => 'top',
						'member_only'    => is_member_only( $post_id ),
						'link'           => get_permalink( $post_id ),
						'cta'            => $show_cta ? $cta_style : null,
						'cta_label'      => $cta_label,
					] );
				}
			} else {
				// no posts found
			}
			?>
		</div>
	</div>
</div>