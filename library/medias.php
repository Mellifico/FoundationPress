<?php
// medias specific outputs functions

// A random picture url from "items" type
if ( ! function_exists( 'pg_medias_random_item_selected_src' ) ) :
function pg_medias_random_item_selected_src() {
$random_item = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'publish',
    'numberposts' => 1,
    'orderby' => 'rand',
        'tax_query' => array(
                array(
            'taxonomy'  => 'classification',
            'field'     => 'slug',
            'terms'     => 'selected',
            'operator'  => 'IN')
            ),
);  
$item = get_posts($random_item);
 
if ($item) {
    foreach ($item as $bg) {

    $bg_src = wp_get_attachment_image_src($bg->ID,'full');
    $item_url = $bg_src[0];
    $item_parent_title = get_the_title($bg->post_parent);
    $item_title = apply_filters('the_title',$bg->post_title);

    echo $item_url;
            }
             
        }
    
    }
endif;