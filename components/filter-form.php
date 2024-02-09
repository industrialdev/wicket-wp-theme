<?php
$defaults   = array(
	'classes'    => [],
	'taxonomies' => [],
);
$args       = wp_parse_args( $args, $defaults );
$classes    = $args['classes'];
$taxonomies = $args['taxonomies'];

?>

<div class="py-8 pr-3">
	<div class="flex items-center gap-3 mb-8">

		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path
				d="M0 20.25C0 19.6406 0.46875 19.125 1.125 19.125H3.89062C4.35938 17.625 5.8125 16.5 7.5 16.5C9.14062 16.5 10.5938 17.625 11.0625 19.125H22.875C23.4844 19.125 24 19.6406 24 20.25C24 20.9062 23.4844 21.375 22.875 21.375H11.0625C10.5938 22.9219 9.14062 24 7.5 24C5.8125 24 4.35938 22.9219 3.89062 21.375H1.125C0.46875 21.375 0 20.9062 0 20.25ZM9 20.25C9 19.4531 8.29688 18.75 7.5 18.75C6.65625 18.75 6 19.4531 6 20.25C6 21.0938 6.65625 21.75 7.5 21.75C8.29688 21.75 9 21.0938 9 20.25ZM16.5 9C18.1406 9 19.5938 10.125 20.0625 11.625H22.875C23.4844 11.625 24 12.1406 24 12.75C24 13.4062 23.4844 13.875 22.875 13.875H20.0625C19.5938 15.4219 18.1406 16.5 16.5 16.5C14.8125 16.5 13.3594 15.4219 12.8906 13.875H1.125C0.46875 13.875 0 13.4062 0 12.75C0 12.1406 0.46875 11.625 1.125 11.625H12.8906C13.3594 10.125 14.8125 9 16.5 9ZM18 12.75C18 11.9531 17.2969 11.25 16.5 11.25C15.6562 11.25 15 11.9531 15 12.75C15 13.5938 15.6562 14.25 16.5 14.25C17.2969 14.25 18 13.5938 18 12.75ZM22.875 4.125C23.4844 4.125 24 4.64062 24 5.25C24 5.90625 23.4844 6.375 22.875 6.375H12.5625C12.0938 7.92188 10.6406 9 9 9C7.3125 9 5.85938 7.92188 5.39062 6.375H1.125C0.46875 6.375 0 5.90625 0 5.25C0 4.64062 0.46875 4.125 1.125 4.125H5.39062C5.85938 2.625 7.3125 1.5 9 1.5C10.6406 1.5 12.0938 2.625 12.5625 4.125H22.875ZM7.5 5.25C7.5 6.09375 8.15625 6.75 9 6.75C9.79688 6.75 10.5 6.09375 10.5 5.25C10.5 4.45312 9.79688 3.75 9 3.75C8.15625 3.75 7.5 4.45312 7.5 5.25Z"
				fill="#232A31" />
		</svg>

		<span class="text-heading-xs font-bold">
			<?php echo __( 'Refine Results', 'wicket' ); ?>
		</span>
	</div>

	<?php
	foreach ( $taxonomies as $taxonomy ) : ?>
		<?php
		$taxonomy_obj = get_taxonomy( $taxonomy['slug'] );
		$terms        = get_terms( $taxonomy['slug'] );
		?>
		<div>
			<button id="<?php echo $taxonomy['slug']; ?>-dropdown-toggle" type="button"
				class="flex w-full gap-3 mb-3 items-center">
				<span class="font-bold">
					<?php echo $taxonomy_obj->labels->singular_name; ?>
				</span>
				<?php if ( $taxonomy['tooltip'] ) {
					get_component( 'tooltip', [ 
						'content'  => $taxonomy['tooltip'],
						'position' => 'right',
					] );
				} ?>
				<span class="ml-auto"></span>
				<i class="fas fa-caret-down"></i>
			</button>
			<div id="<?php echo $taxonomy['slug']; ?>-dropdown">
				<?php
				$term_query = isset( $_GET[ $taxonomy['slug'] ] ) ? $_GET[ $taxonomy['slug'] ] : '';
				?>
				<ul>
					<?php
					foreach ( $terms as $term ) : ?>
						<li>
							<?php
							$checkedState = FALSE;
							if ( is_array( $term_query ) ) {
								if ( in_array( $term->slug, $term_query ) ) {
									$checkedState = TRUE;
								}
							} elseif ( $term_query == $term->slug ) {
								$checkedState = TRUE;
							}
							?>
							<div class="form__checkbox">
								<input id="<?php echo $taxonomy['slug'] . '_' . $term->slug; ?>" class="filters__option" type="checkbox"
									name="<?php echo $taxonomy['slug']; ?>[]" value="<?php echo $term->slug; ?>" <?php if ( $checkedState ) : ?>checked<?php endif; ?>>
								<label for="<?php echo $taxonomy['slug'] . '_' . $term->slug; ?>">
									<?php echo $term->name; ?>
								</label>
							</div>
						</li>
						<?php
					endforeach; ?>
				</ul>
			</div>
		</div>
		<?php
	endforeach; ?>
</div>