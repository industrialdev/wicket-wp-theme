<?php
/**
 * Template Name: Kitchen Sink WooCommerce Page.
 */
get_header();

if (have_posts()) : while (have_posts()) : the_post(); ?>

    <main class="py-5">
      <div class="container">

        <h1 class="mb-6"><?php the_title(); ?></h1>

        <div class="mb-6">
          <h2 class="text-heading-lg mb-5">Notices</h2>

          <?php
            $notices = [
              'error',
              'success',
              'notice',
            ];

            foreach ( $notices as $notice_type ) {
              echo '<h3 class="text-heading-xs mb-2">' . ucfirst( $notice_type ) . ':</h3>';
              wc_get_template(
                "notices/{$notice_type}.php",
                array(
                  'notices'  => array(
                    array(
                      'notice' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec suscipit auctor dui, sed efficitur enim.',
                    ),
                  ),
                )
              );
            }
          ?>
        </div>


        <?php the_content(); ?>
      </div>
    </main>

<?php endwhile;
endif; ?>

<?php get_footer(); ?>