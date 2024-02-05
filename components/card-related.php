<?php
$defaults       = array(
	'classes'      => [],
	'content_type' => '',
	'link'         => [],
	'document'     => [],
	'display_text' => '',
	'icon'         => '',
	'layout_style' => '',
);
$args           = wp_parse_args( $args, $defaults );
$classes        = $args['classes'];
$content_type   = $args['content_type'];
$link           = $args['link'];
$document       = $args['document'];
$display_text   = $args['display_text'];
$icon           = $args['icon'];
$layout_style   = $args['layout_style'];
$classes[]      = 'p-4 bg-white border border-light-020 flex gap-4';
$button_link    = '';
$button_label   = '';
$button_icon    = '';
$button_target  = '_self';
$button_classes = [];
$icon_id        = $icon['id'] ?? '';

// Case: Layout style is list
if ( $layout_style === 'list' ) {
	$classes[] = 'flex-row items-center';
}

// Case: Layout style is card
if ( $layout_style === 'card' ) {
	$classes[] = 'flex-col items-start';
}

// Case: Content type is document
if ( $content_type === 'document' && $document ) {
	$icon             = 'fa-regular fa-file-lines';
	$button_link      = $document['url'];
	$button_label     = __( 'Download', 'wicket' );
	$button_icon      = 'fa-solid fa-arrow-down-to-bracket';
	$button_classes[] = $layout_style === 'card' ? 'w-full justify-center' : 'ml-auto min-w-36';
	$button_target    = '_blank';
}

// Case: Content type is link
if ( $content_type === 'link' && $link ) {
	$link_target      = $link['target'] ?? '_self';
	$icon             = $link_target === '_blank' ? 'fa-regular fa-external-link' : 'fa-regular fa-link';
	$button_link      = $link['url'];
	$button_label     = $link['title'];
	$button_icon      = $link_target === '_blank' ? 'fa-regular fa-external-link' : 'fa-solid fa-arrow-right';
	$button_classes[] = $layout_style === 'card' ? 'w-full justify-center' : 'ml-auto min-w-36';
	$button_target    = $link_target;
}
?>

<div class="<?php echo implode( ' ', $classes ) ?>">
	<?php if ( $icon_id ) {
		get_component( 'image', [ 
			'id'      => $icon_id,
			'classes' => [ $layout_style === 'card' ? 'max-h-8' : 'max-h-6' ],
		] );
	} else {
		get_component( 'icon', [ 
			'icon'    => $icon,
			'classes' => [ 
				$layout_style === 'card' ? 'text-[32px]' : 'text-[24px]',
				$layout_style === 'list' ? 'w-6' : '',
				'leading-none',
				'inline-flex',
			],
		] );
	} ?>

	<?php if ( $display_text ) { ?>
		<div class="text-heading-xs text-dark-100 font-bold leading-7">
			<?php echo $display_text; ?>
		</div>
	<?php } ?>

	<?php if ( $button_link ) {
		get_component( 'button', [ 
			'variant'     => 'primary',
			'label'       => $button_label,
			'suffix_icon' => $button_icon,
			'a_tag'       => true,
			'link'        => $button_link,
			'link_target' => $button_target,
			'classes'     => $button_classes,
			'atts'        => [ $content_type === 'document' ? 'download' : '' ],
		] );
	} ?>
</div>