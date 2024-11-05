<?php
/*
Plugin Name: Custom Search Excerpt
Plugin URI: https://ballarinconsulting.com/plugins
Description: A WordPress plugin that customizes excerpts in search results to show text around first search keyword.
Version: 0.0.1
Author: David Ballarin Prunera
Author URI: https://profiles.wordpress.org/dballari/
License: GPL3
*/

/**
 * Customize search excerpt to include text around search keywords.
 *
 * @param string $excerpt The original excerpt.
 * @param WP_Post $post_obj The post object.
 * @return string Modified excerpt.
 */
function custom_excerpt_for_search($excerpt, $post_obj) {
    if (is_search()) {
        // Get the full content of the post
        $full_text = wp_strip_all_tags($post_obj->post_content);
        // Search keywords
        $search_terms = explode(' ', get_query_var('s'));
        // Loop through search keywords and find matches
        foreach ($search_terms as $term) {
            $text_to_search = $full_text;
            $pos = stripos($text_to_search, $term);
            if ($pos !== false) {
                // Extract text around the keyword, adjust length as needed
                $excerpt = substr($text_to_search, max(0, $pos - 50), 400);
                break; // Only extract content for the first keyword match
            }
        }
    }
    return $excerpt;
}

// Add the filter to apply custom excerpts on search results
add_filter('get_the_excerpt', 'custom_excerpt_for_search', 10, 2);
