<?php
$defaults  = array(
	'classes'               => [],
  'items'                 => [],
  'icon-type'             => 'plus-minus',
  'spacing-between-items' => true,
  'separate-title-body'   => false,
);
$args                  = wp_parse_args( $args, $defaults );
$classes               = $args['classes'];
$items                 = $args['items'] ?? [];
$icon_type             = $args['icon-type'];
$spacing_between_items = $args['spacing-between-items'];
$separate_title_body   = $args['separate-title-body'];

$font_awesome_icon_open = 'fa-solid fa-minus';
$font_awesome_icon_closed = 'fa-solid fa-plus';
if( $icon_type == 'chevrons' ) {
  $font_awesome_icon_open = 'fa-solid fa-circle-chevron-up';
  $font_awesome_icon_closed = 'fa-solid fa-circle-chevron-down';
}

$classes[] = '@container w-full';
?>

<div 
  class="<?php echo implode( ' ', $classes ); ?>"
  <?php if(!is_admin()) { echo "x-data='{ openAccordion: 999 }'"; } ?>
  >

  <?php 
  $i = 0;
  foreach( $items as $item ) : 
  ?>
  <div 
    class="bg-tertiary-030 bg-opacity-20 p-2 hover:cursor-pointer <?php if($spacing_between_items){ echo 'rounded-100 mb-3'; } ?>"
    x-bind:class="openAccordion == <?php echo $i; ?> ? 'border border-tertiary-100' : ''"
    x-on:click="openAccordion = <?php echo $i; ?>"
  >
    <div class="flex w-full justify-between items-center">
      <h4 class="font-bold text-body-lg"><?php echo $item['title']; ?></h4>
      <?php 
        get_component( 'icon', [ 
          'icon' => $font_awesome_icon_open,
          'classes' => ['text-heading-2xl', 'text-tertiary-100', 'ml-4'],
          'atts' => ["x-show='openAccordion == " . $i . "'"]
        ] );
      ?>
      <?php 
        get_component( 'icon', [ 
          'icon' => $font_awesome_icon_closed,
          'classes' => ['text-heading-2xl', 'text-tertiary-100', 'ml-4'],
          'atts' => ["x-show='openAccordion != " . $i . "'"]
        ] );
      ?>
    </div>
    <div 
      class="mt-1 pr-12"
      x-show="openAccordion == <?php echo $i; ?>"
    >
      <?php echo $item['body_content']; ?>
    </div>

  </div>
  <?php 
  $i++;
  endforeach; 
  ?>
</div>
