(function($){

wp.domReady(() => {

  // Unregister individual button styles
  wp.blocks.unregisterBlockStyle('core/button', 'outline')
  wp.blocks.unregisterBlockStyle('core/button', 'squared')
  wp.blocks.unregisterBlockStyle('core/button', 'fill')

  wp.blocks.registerBlockStyle('core/button', [
    {
      name: 'secondary',
      label: 'Secondary',
    },
    {
      name: 'ghost',
      label: 'Ghost',
    },
    {
      name: 'primary_reversed',
      label: 'Default (Reversed)',
    },
    {
      name: 'secondary_reversed',
      label: 'Secondary (Reversed)',
    },
    {
      name: 'ghost_reversed',
      label: 'Ghost (Reversed)',
    },
  ])
})


})(jQuery);