<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'inisiat_listing' ) {
    return;
}
extract( $args );
extract( $instance );
if ( !empty($instance['title']) ) {
	$title = apply_filters('widget_title', $instance['title']);

	if ( !empty($title) ) {
	    echo trim($before_title)  . trim( $title ) . $after_title;
	}
}

?>
<div class="inisiat-detail-map-location inisiat_maps_sidebar">
    <div id="inisiats-google-maps" class="single-inisiat-map"></div>
</div>