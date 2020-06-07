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
		'post_type' => 'inisiat_listing',
	    'post_status' => 'publish',
	    'post_per_page' => wp_inisiat_board_get_option('number_inisiats_per_page', 10),
	    'paged' => $paged,
	);
	$params = true;
	if ( WP_inisiat_Board_inisiat_Filter::has_filter() ) {
		$params = $_GET;
	}

	$inisiats = WP_inisiat_Board_Query::get_posts($query_args, $params);
	
	if ( 'inisiats' !== $_REQUEST['load_type'] ) {
		echo WP_inisiat_Board_Template_Loader::get_template_part('archive-inisiat_listing-ajax-full', array('inisiats' => $inisiats));
	} else {
		echo WP_inisiat_Board_Template_Loader::get_template_part('archive-inisiat_listing-ajax-inisiats', array('inisiats' => $inisiats));
	}
} else {
	get_header();

	$layout_type = temp_get_inisiats_layout_type();

	if ( $layout_type == 'half-map' ) {
	?>
		<section id="main-container" class="inner">
			<div class="row no-margin layout-type-<?php echo esc_attr($layout_type); ?>">
				<div id="main-content" class="col-sm-12 col-md-7 no-padding">
					<div class="inner-left">
						<?php if ( is_active_sidebar( 'inisiats-filter-sidebar' ) ): ?>
							<div class="filter-sidebar">
								<div class="sanar-groups-button hidden-lg hidden-md clearfix text-center">
									<button class=" btn btn-sm btn-theme btn-view-map" type="button"><i class="fa fa-map-o" aria-hidden="true"></i> </button>
									<button class=" btn btn-sm btn-theme  btn-view-listing hidden-sm hidden-xs" type="button"><i class="fa fa-list" aria-hidden="true"></i>?></button>
								</div>
								<span class="filter-in-sidebar visible-xs visible-sm"><i class="fa fa-sliders"></i></span>
								<div class="filter-scroll">
						   			<?php dynamic_sidebar( 'inisiats-filter-sidebar' ); ?>
						   		</div>
						   	</div>
						   	<div class="over-dark"></div>
					   	<?php endif; ?>
					   	<div class="content-listing">
					   		
							<?php
				
							while ( have_posts() ) : the_post();
								
				
								the_content();

								if ( texter_open() || get_texter_number() ) :
									texter_template();
								endif;

						
							endwhile;
							?>
						</div>
					</div><!-- .site-main -->
				</div><!-- .content-area -->
				<div class="col-md-5 no-padding">
					<div id="inisiats-google-maps" class="hidden-sm hidden-xs fix-map"></div>
				</div>
			</div>
		</section>
	<?php
	} else {
		$sidebar_configs = temp_get_inisiats_layout_configs();
		$filter_top_sidebar = temp_get_inisiats_filter_top_sidebar();
	?>
		<?php if ( $filter_top_sidebar && is_active_sidebar( 'inisiats-filter-top-sidebar' ) ) { ?>
			<div class="inisiats-filter-top-sidebar-wrapper filter-top-sidebar-wrapper">
		   		<?php dynamic_sidebar( 'inisiats-filter-top-sidebar' ); ?>
		   	</div>
		<?php } ?>
		<section id="main-container" class=" main-content <?php echo apply_filters('temp_page_content_class', 'container');?> inner">
			<?php if(temp_get_inisiats_layout_type() !== 'main') { ?>
				<?php temp_before_content( $sidebar_configs ); ?>
			<?php } ?>
			<div class="row">
				<?php temp_display_sidebar_left( $sidebar_configs ); ?>

				<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
					<main id="main" class="site-main layout-type-<?php echo esc_attr($layout_type); ?>" role="main">

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
				<?php if(temp_get_inisiats_layout_type() == 'main') { ?>
					<div class="over-dark"></div>	
				<?php } ?>
			</div>
		</section>
	<?php
	}

	get_footer();
}