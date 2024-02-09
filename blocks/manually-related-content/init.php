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
	$buttons_equal_width   = get_field( 'manually_related_content_make_buttons_same_width' );
	$posts_wrapper_classes = [ 
		'grid',
		'gap-3',
		'grid-cols-1',
		'items-start',
		'px-4',
		'xl:px-0'
	];
	$placeholder_styles = '';
	if( is_admin() ){ 
		$placeholder_styles = 'style="min-height: 40px;border: 1px solid var(--wp--preset--color--light);"';
	}

	if ( ! $posts ) {
		$output = '<div ' . $placeholder_styles . '>';
		if( is_admin() ) {
			$output .= "<p>" . __('Use the Block controls on the right to add manually related content.', 'wicket') . "</p>";
		}
		$output .= '</div>';
		echo $output;
		return;
	}

	if ( $layout_style === 'card' ) {
		$posts_wrapper_classes[] = 'lg:grid-cols-' . $column_count;
	}

	if ( $layout_style === 'list' ) {
		$posts_wrapper_classes[] = 'lg:grid-cols-1';
	}

	


	echo '<div ' . $attrs . ' ' . $placeholder_styles . '>';

	if( is_admin() && empty($posts) && empty($title) ) {
		echo "<p>" . __('Use the Block controls on the right to add manually related content.', 'wicket') . "</p>";
	}

	if ( $title ) {
		echo '<div class="text-heading-sm font-bold mb-3">' . $title . '</div>';
	}

	// TODO: If $buttons_equal_width is true, get width of widest button with JS and echo a rule
	// that forces that style for all buttons

	echo '<div class="' . implode( ' ', $posts_wrapper_classes ) . '">';
	foreach ( $posts as $post ) {
		$content_type       = $post['content_type'];
		$link               = $post['link'];
		$document           = $post['document'];
		$title_text         = $post['display_text'];
		$body_text          = $post['body_text']; //
		$cta_label_override = $post['cta_label_override']; //
		$icon_type				  = $post['icon_type']; //
		$icon_img           = $post['icon'];

		get_component( 'card-related', [ 
			'content_type'       => $content_type,
			'link'               => $link,
			'document'           => $document,
			'display_text'       => $title_text,
			'icon_type'		       => $icon_type,
			'icon'               => $icon_img,
			'layout_style'       => $layout_style,
			'body_text'          => $body_text,
			'cta_label_override' => $cta_label_override,
		] );
	}
	echo '</div>';
	echo '</div>';
}
