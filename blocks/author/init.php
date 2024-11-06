<?php
/**
 * Wicket author block
 *
 **/

namespace Wicket\Blocks\Wicket_Author;

function init($block = [])
{
    $attrs = get_block_wrapper_attributes(
        [ 'class' => 'block-wicket-author' ]
    );

    $title   = get_field('author_title');
    $authors = get_field('author_authors');

    echo '<div ' . $attrs . '>';

    if ($title) {
        echo '<div class="block-wicket-author__top-wrap">';
        echo '<div class="block-wicket-author__title">' . $title . '</div>';
        echo '<span class="block-wicket-author__border"></span>';
        echo '</div>';
    }

    if ($authors) {
        echo '<div class="flex flex-col gap-[--space-400]">';
        foreach ($authors as $author) {
            get_component('author', [
                'author'             => $author['author'] ?? null,
                'hide_profile_image' => $author['hide_profile_image'] ?? false,
                'hide_bio'           => $author['hide_bio'] ?? false,
            ]);
        }
        echo '</div>';
    }

    echo '</div>';
}
