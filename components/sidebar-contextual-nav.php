<?php
$defaults  = array(
	'classes'               => [],
);
$args                  = wp_parse_args( $args, $defaults );
global $post;
$current_post_id       = $post->ID;
wicket_get_all_parent_and_child_pages($current_post_id);

$classes[] = '@container w-full';
$placeholder_styles = 'style="min-height: 40px;border: 1px solid var(--wp--preset--color--light);"';
?>

<div 
  class="<?php echo implode( ' ', $classes ); ?>"
  <?php if( is_admin() && empty($items) ){ echo $placeholder_styles; } ?>
  >
</div>