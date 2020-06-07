<?php


if ( isset( $_REQUEST['load_type'] ) && WP_inisiat_Board_Mixes::is_ajax_request() ) {
	if ( get_query_var( 'paged' ) ) {
	    $paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
	    $paged = get_query_var( 'page' );
	} else {
	    $paged = 1;
	}

	$query_args = array(
		'post_type' => 'inisiat_lomer',
	    'post_status' => 'publish',
	    'post_per_page' => wp_inisiat_board_get_option('number_inisiat_lom_per_page', 10),
	    'paged' => $paged,
	);
	$params = true;
	if ( WP_inisiat_Board_lom_Filter::has_filter() ) {
		$params = $_GET;
	}
	$inisiat_lom = WP_inisiat_Board_Query::get_posts($query_args, $params);
	
	if ( 'items' !== $_REQUEST['load_type'] ) {
		echo WP_inisiat_Board_Template_Loader::get_template_part('archive-inisiat_lomer-ajax-full', array('inisiat_lom' => $inisiat_lom));
	} else {
		echo WP_inisiat_Board_Template_Loader::get_template_part('archive-inisiat_lomer-ajax-inisiat_lom', array('inisiat_lom' => $inisiat_lom));
	}
} else {
	get_header();
	$sidebar_configs = temp_get_page_layout_configs();
	$filter_top_sidebar = temp_get_inisiat_lom_filter_top_sidebar();
	?>
	<?php if ( $filter_top_sidebar && is_active_sidebar( 'inisiat_lom-filter-top-sidebar' ) ) { ?>
		<div class="inisiat_lom-filter-top-sidebar-wrapper filter-top-sidebar-wrapper">
	   		<?php dynamic_sidebar( 'inisiat_lom-filter-top-sidebar' ); ?>
	   	</div>
	<?php } ?>
	<section id="main-container" class="main-content <?php echo apply_filters('temp_page_content_class', 'container');?> inner">
		<?php temp_before_content( $sidebar_configs ); ?>
		<div class="row">
			<?php temp_display_sidebar_left( $sidebar_configs ); ?>

			<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
				<main id="main" class="site-main" role="main">

					<?php
					
					while ( have_posts() ) : the_post();
						
						
						the_content();

					
						if ( texter_open() || get_texter_number() ) :
							texter_template();
						endif;

				
					endwhile;
					?>
					
				</main><!-- .site-main -->
			</div><!-- .content-area -->
			
			<?php temp_display_sidebar_right( $sidebar_configs ); ?>
		</div>
	</section>

	<?php get_footer();
}