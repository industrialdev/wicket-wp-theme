<?php
/**
 * Wicket Manually Related Content Block
 *
 **/

namespace Wicket\Blocks\Wicket_Manually_Related_Content;

/**
 * Initialize the Manually Related Content block.
 *
 * @param array $block The block settings and attributes.
 *
 * @return void
 */
function init( $block = [] ) {

	$attrs                 = get_block_wrapper_attributes();
	$title                 = get_field( 'manually_related_content_title' );
	$posts                 = get_field( 'manually_related_content_posts' );
	$layout_style          = get_field( 'manually_related_content_layout_style' );
	$column_count          = get_field( 'manually_related_content_column_count' );
	$posts_wrapper_classes = [ 
		'grid',
		'gap-3',
		'grid-cols-1',
		'items-start',
	];

	if ( ! $posts ) {
		return;
	}

	if ( $layout_style === 'card' ) {
		$posts_wrapper_classes[] = 'lg:grid-cols-' . $column_count;
	}

	if ( $layout_style === 'list' ) {
		$posts_wrapper_classes[] = 'lg:grid-cols-1';
	}

	echo '<div ' . $attrs . '>';

	if ( $title ) {
		echo '<div class="text-heading-sm font-bold mb-3">' . $title . '</div>';
	}

	echo '<div class="' . implode( ' ', $posts_wrapper_classes ) . '">';
	foreach ( $posts as $post ) {
		$content_type = $post['content_type'];
		$link         = $post['link'];
		$document     = $post['document'];
		$display_text = $post['display_text'];
		$icon         = $post['icon'];

		get_component( 'card-related', [ 
			'content_type' => $content_type,
			'link'         => $link,
			'document'     => $document,
			'display_text' => $display_text,
			'icon'         => $icon,
			'layout_style' => $layout_style,
		] );
	}
	echo '</div>';
	echo '</div>';
}