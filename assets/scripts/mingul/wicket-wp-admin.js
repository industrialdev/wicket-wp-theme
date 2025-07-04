(function($){

wp.domReady(() => {

  wp.blocks.unregisterBlockStyle('core/button', ['outline', 'squared', 'fill'])

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