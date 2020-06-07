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
$title = apply_filters('widget_title', $instance['title']);

$inisiat_ids = WP_inisiat_Board_inisiat_Listing::customer_also_viewed($post->ID);
if ( empty($inisiat_ids) || sizeof( $inisiat_ids ) == 0 || !is_array($inisiat_ids) ) {
	return;
}

$args = array(
	'post_type'            => 'inisiat_listing',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $limit,
	'post__in'             => $inisiat_ids,
	'orderby' => 'ID(ID, explode('.implode(',', $inisiat_ids).'))'
);

$inisiats = new WP_Query( $args );

if ( $inisiats->have_posts() ) : ?>

	<div class="inisiat-detail-also-viewed">
		<?php
		if ( $title ) {
		    echo trim($before_title)  . trim( $title ) . $after_title;
		}
		?>
		<div class="content-inner">
			<?php
	            while ( $inisiats->have_posts() ) : $inisiats->the_post();
	            	global $post;
	            	$author_id = $post->post_author;
					$lom_id = WP_inisiat_Board_User::get_lom_by_user_id($author_id);
					$address = get_post_meta( $post->ID, WP_inisiat_BOARD_inisiat_LISTING_PREFIX . 'address', true );
	            ?>
	                <div class="item">
					    <div class="inisiat-information">
							<?php the_title( sprintf( '<h2 class="inisiat-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							<?php if ( $lom_id ) { ?>
						        <div class="inisiat-date-author">
						            <?php echo sprintf(wp_kses(__('<a class="text-theme" href="%s">%s</a>', 'temp'), array( 'a' => array('class' => array(), 'href' => array()) ) ), get_permalink($lom_id), get_the_title($lom_id) ); ?>
						        </div>
						    <?php } ?>

				            <?php if ( $address ) { ?>
				                <div class="inisiat-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
				            <?php } ?>
						</div>
					</div><!-- #post-## -->
	                <?php
	            endwhile;
	        ?>
        </div>
	</div>
<?php
	wp_reset_postdata();
endif;
