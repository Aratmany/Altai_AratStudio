<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$args = array(
    'limit' => $number_post,
    'get_inisiat_lom_by' => $get_inisiat_lom_by,
    'orderby' => $orderby,
    'order' => $order,
);

$loop = temp_get_inisiat_lom($args);
if ( $loop->have_posts() ):
?>
<div class="inisiat_lom-widget">
	<?php
		while ( $loop->have_posts() ): $loop->the_post();
			get_template_part( 'template-inisiats/inisiat_lom-styles/inner', 'list-small');
	    endwhile;
    	wp_reset_postdata();
    ?>
</div>
<?php endif; ?>