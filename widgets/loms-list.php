<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$args = array(
    'limit' => $number_post,
    'get_inisiats_by' => $get_inisiats_by,
    'orderby' => $orderby,
    'order' => $order,
);

$loop = temp_get_inisiats($args);
if ( $loop->have_posts() ):
?>
<div class="inisiats-widget">
	<?php
		while ( $loop->have_posts() ): $loop->the_post();
			get_template_part( 'template-inisiats/inisiats-styles/inner', 'list-small');
	    endwhile;
    	wp_reset_postdata();
    ?>
</div>
<?php endif; ?>