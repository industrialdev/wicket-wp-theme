<?php
$defaults  = array(
	'classes'               => [],
  'items'                 => [],
  'icon-type'             => 'plus-minus',
  'accordion-type'        => 'list',
  'separate-title-body'   => false,
);
$args                  = wp_parse_args( $args, $defaults );
$classes               = $args['classes'];
$items                 = $args['items'] ?? [];
$icon_type             = $args['icon-type'];
$accordion_type        = $args['accordion-type'];
$separate_title_body   = $args['separate-title-body'];

$font_awesome_icon_open = 'fa-solid fa-minus';
$font_awesome_icon_closed = 'fa-solid fa-plus';
if( $icon_type == 'chevrons' ) {
  $font_awesome_icon_open = 'fa-solid fa-circle-chevron-up';
  $font_awesome_icon_closed = 'fa-solid fa-circle-chevron-down';
}

$classes[] = '@container w-full';
$placeholder_styles = 'style="min-height: 40px;border: 1px solid var(--wp--preset--color--light);"';
?>

<div 
  class="<?php echo implode( ' ', $classes ); ?>"
  <?php if(!is_admin()) { echo "x-data='{ openAccordion: 999 }'"; } ?>
  <?php if( is_admin() && empty($items) ){ echo $placeholder_styles; } ?>
  >

  <?php if( is_admin() && empty($items) ): ?>
  <p><?php _e('Use the Block controls on the right to add accordion items.', 'wicket'); ?></p>
  <?php endif; ?>

  <?php 
  $i = 0;
  foreach( $items as $item ) : 
  ?>
  <div 
    class="accordion-item p-2 hover:cursor-pointer <?php if($accordion_type == 'card'){ echo 'rounded-100 border border-light-100 mb-3'; } else { echo 'border-b border-light-100 border-solid '; } if( $i == 0 && $accordion_type == 'list' ) { echo ' border-t'; } ?>"
    x-bind:class="openAccordion == <?php echo $i; ?> ? 'border-b-4 bg-light-020 bg-opacity-20 <?php if($accordion_type == 'card') { echo 'border-light-120'; } ?>' : ''"
    x-on:click="if(openAccordion == <?php echo $i; ?>){ openAccordion = 999; }else{ openAccordion = <?php echo $i; ?> }"
  >
    <div class="flex w-full justify-between items-center">
      <h4 class="font-bold text-body-lg"><?php echo $item['title']; ?></h4>
      <?php 
        get_component( 'icon', [ 
          'icon' => $font_awesome_icon_open,
          'classes' => ['text-heading-lg', 'text-dark-100', 'ml-4'],
          'atts' => ["x-show='openAccordion == " . $i . "'"]
        ] );
      ?>
      <?php 
        get_component( 'icon', [ 
          'icon' => $font_awesome_icon_closed,
          'classes' => ['text-heading-lg', 'text-dark-100', 'ml-4'],
          'atts' => ["x-show='openAccordion != " . $i . "'"]
        ] );
      ?>
    </div>
    <?php if( !$separate_title_body ): ?>
    <div 
      class="mt-1 pr-12"
      x-show="openAccordion == <?php echo $i; ?>"
      x-transition
    >
      <?php echo $item['body_content']; ?>

      <?php if( !empty( $item['call_to_action']['cta_label'] ) && !empty( $item['call_to_action']['link'] ) && $item['call_to_action']['button_link_style'] != 'link' ) {
        get_component( 'button', [
          'variant'     => $item['call_to_action']['button_link_style'],
          'label'       => $item['call_to_action']['cta_label'],
          'link'        => $item['call_to_action']['link'],
          'link_target' => $item['call_to_action']['cta_link_opens_new_window'] ? '_blank' : '_self',
          'a_tag'       => true,
          'classes'     => ['mt-4'],
          'suffix_icon' => $item['call_to_action']['cta_link_opens_new_window'] ? 'fa-solid fa-arrow-up-right-from-square' : '',
        ] );
      } else if( !empty( $item['call_to_action']['cta_label'] ) && !empty( $item['call_to_action']['link'] ) && $item['call_to_action']['button_link_style'] == 'link' ) {
        get_component( 'link', [
          'text'     => $item['call_to_action']['cta_label'],
          'url'      => $item['call_to_action']['link'],
          'target'   => $item['call_to_action']['cta_link_opens_new_window'] ? '_blank' : '_self',
          'classes'  => ['mt-4', 'block', 'font-bold'],
          'icon_end' => [ 
            'icon' => $item['call_to_action']['cta_link_opens_new_window'] ? 'fa-solid fa-arrow-up-right-from-square' : '',
            ],
        ] );
      } ?>
    </div>
    <?php endif; ?>

  </div>

  <?php if( $separate_title_body ): ?>
  <div 
    class="py-4 px-12 <?php if($accordion_type == 'list') { echo 'border-b border-light-100'; } ?>"
    x-show="openAccordion == <?php echo $i; ?>"
    x-transition
  >
    <?php echo $item['body_content']; ?>

    <?php if( !empty( $item['call_to_action']['cta_label'] ) && !empty( $item['call_to_action']['link'] ) && $item['call_to_action']['button_link_style'] != 'link' ) {
        get_component( 'button', [
          'variant'     => $item['call_to_action']['button_link_style'],
          'label'       => $item['call_to_action']['cta_label'],
          'link'        => $item['call_to_action']['link'],
          'link_target' => $item['call_to_action']['cta_link_opens_new_window'] ? '_blank' : '_self',
          'a_tag'       => true,
          'classes'     => ['mt-4'],
          'suffix_icon' => $item['call_to_action']['cta_link_opens_new_window'] ? 'fa-solid fa-arrow-up-right-from-square' : '',
        ] );
      } else if( !empty( $item['call_to_action']['cta_label'] ) && !empty( $item['call_to_action']['link'] ) && $item['call_to_action']['button_link_style'] == 'link' ) {
        get_component( 'link', [
          'text'     => $item['call_to_action']['cta_label'],
          'url'      => $item['call_to_action']['link'],
          'target'   => $item['call_to_action']['cta_link_opens_new_window'] ? '_blank' : '_self',
          'classes'  => ['mt-4', 'block', 'font-bold'],
          'icon_end' => [ 
            'icon' => $item['call_to_action']['cta_link_opens_new_window'] ? 'fa-solid fa-arrow-up-right-from-square' : '',
            ],
        ] );
      } ?>
  </div>
  <?php endif; ?>

  <?php 
  $i++;
  endforeach; 
  ?>
</div>
