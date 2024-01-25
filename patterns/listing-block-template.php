<?php
/**
 * Title: A block template for listings
 * Slug: wicket/listing-block-template
 * Inserter: true
 * Categories: wicket 
 */

?>
<!-- wp:columns {"lock":{"move":true,"remove":true},"align":"wide","style":{"spacing":{"blockGap":"40px"}}} -->
<div class="wp-block-columns alignwide">

<!-- wp:column {"width":"33.33%","lock":{"move":true,"remove":true}} -->
<div class="wp-block-column" style="flex-basis:33.33%">
<!-- wp:post-featured-image {"lock":{"move":true,"remove":true}} /-->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"66.66%","lock":{"move":true,"remove":true},"style":{"spacing":{"padding":{"top":"40px","right":"40px","bottom":"40px","left":"40px"}}},"backgroundColor":"tertiary"} -->
<div class="wp-block-column has-tertiary-background-color has-background" style="padding-top:40px;padding-right:40px;padding-bottom:40px;padding-left:40px;flex-basis:66.66%">
<!-- wp:group {"lock":{"move":true,"remove":true},"style":{"spacing":{"blockGap":"10px"}}} -->
<div class="wp-block-group">
<!-- wp:post-title {"lock":{"move":true,"remove":true},"fontSize":"x-large"} /-->
<!-- wp:paragraph {"placeholder":"Listing Type","lock":{"move":true,"remove":true},"style":{"typography":{"fontStyle":"normal","fontWeight":"500"}},"fontSize":"medium"} -->
<p class="has-medium-font-size" style="font-style:normal;font-weight:500"></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph {"placeholder":"Listing Description — Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin finibus mauris, in tincidunt arcu pharetra et. Nulla lorem urna, viverra sed luctus non, hendrerit nec ligula. Nam in mollis turpis. Curabitur tincidunt mollis metus sit amet dictum.","lock":{"move":true,"remove":true}} -->
<p></p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"lock":{"move":true,"remove":true}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Start Reading</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->