<?php
/**

 */



if ( ! function_exists( 'temp_setup' ) ) :

function temp_setup() {



	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 750, true );
	add_image_size( 'temp-text-small', 90, 80, true );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'temp' ),
		'lom-menu' => esc_html__( 'lom Menu', 'temp' ),
		'inisiat_lomer-menu' => esc_html__( 'inisiat_lomer Menu', 'temp' ),
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );



	$color_scheme  = temp_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );



	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'wp-block-styles' );


	add_theme_support( 'align-wide' );



	temp_get_load_plugins();
}
endif;




function temp_get_fonts_url() {
    $fonts_url = '';

    */
    $roboto = _x( 'on', 'Roboto font: on or off', 'temp' );
    $nunito = _x( 'on', 'Nunito font: on or off', 'temp' );

    if ( 'off' !== $roboto || 'off' !== $nunito ) {
        $font_families = array();
        if ( 'off' !== $roboto ) {
            $font_families[] = 'Roboto:400,500,700,900';
        }
        if ( 'off' !== $nunito ) {
            $font_families[] = 'Nunito:400,600,700,800&display=swap';
        }
        $query_args = array(
            'family' => ( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 		
 		$protocol = is_ssl() ? 'https:' : 'http:';
        $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}

function temp_enqueue_styles() {
	

	wp_enqueue_style( 'temp-theme-fonts', temp_get_fonts_url(), array(), null );

	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );


	wp_enqueue_style( 'font-flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );


	wp_enqueue_style( 'font-themify', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );
		

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.6.0' );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.2.0' );
	

	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.0' );

	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0' );

	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );

	wp_enqueue_style( 'jquery-scrollbar', get_template_directory_uri() . '/css/jquery.scrollbar.css', array(), '0.2.11' );

	wp_enqueue_style( 'jquery-mmenu', get_template_directory_uri() . '/js/mmenu/jquery.mmenu.css', array(), '0.6.12' );

	wp_enqueue_style( 'temp-template', get_template_directory_uri() . '/css/template.css', array(), '1.0' );
	
	$custom_style = temp_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'temp-template', $custom_style );
	}
	wp_enqueue_style( 'temp-style', get_template_directory_uri() . '/style.css', array(), '1.0' );


}
add_action( 'wp_enqueue_scripts', 'temp_enqueue_styles', 100 );

function temp_login_enqueue_styles() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );
	wp_enqueue_style( 'temp-login-style', get_template_directory_uri() . '/css/login-style.css', array(), '1.0' );
}
add_action( 'login_enqueue_scripts', 'temp_login_enqueue_styles', 10 );

function temp_enqueue_scripts() {
	
	if ( is_singular() && texter_open() && get_option( 'thread_texter' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20150330', true );

	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.8.0', true );

	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), '20150315', true );



	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );

	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );

	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), '0.6.12', true );


	wp_enqueue_script( 'jquery-scrollbar', get_template_directory_uri() . '/js/jquery.scrollbar.min.js', array( 'jquery' ), '0.2.11', true );
	
	if ( temp_get_config('enable_smooth_scroll') ) {
		wp_enqueue_script( 'SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll.js', '1.3.0', true );
	}

	wp_enqueue_script( 'jquery-mmenu', get_template_directory_uri() . '/js/mmenu/jquery.mmenu.js', array( 'jquery' ), '0.6.12', true );
	

	wp_register_script('addthis', '//s7.addthis.com/js/250/addthis_widget.js', array(), '0.6.12', true);


	wp_register_script( 'temp-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );

	wp_enqueue_script( 'temp-functions' );
	
	wp_add_inline_script( 'temp-functions', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'temp_enqueue_scripts', 1 );



function temp_get_opt_name() {
	return 'temp_theme_options';
}
add_filter( 'tempus_framework_get_opt_name', 'temp_get_opt_name' );



function temp_get_config($name, $default = '') {
	global $temp_options;
    if ( isset($temp_options[$name]) ) {
        return $temp_options[$name];
    }
    return $default;
}


add_action( 'widgets_init', 'temp_widgets_init' );


require get_template_directory() . 'temp/functions-frontend.php';


require get_template_directory() . 'temp/custom-header.php';



require get_template_directory() . 'temp/template-tags.php';

if ( defined( 'tempus_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require get_template_directory() . 'temp/vendors/redux-framework/redux-config.php';
	define( 'temp_REDUX_FRAMEWORK_ACTIVED', true );
}
if( temp_is_cmb2_activated() ) {
	require get_template_directory() . 'temp/vendors/cmb2/page.php';
	define( 'temp_CMB2_ACTIVED', true );
}


if( temp_is_wp_inisiat_board_activated() ) {
	require get_template_directory() . 'temp/vendors/wp-inisiat-board/functions-redux-configs.php';
	require get_template_directory() . 'temp/vendors/wp-inisiat-board/functions.php';
	require get_template_directory() . 'temp/vendors/wp-inisiat-board/functions-lom.php';
	require get_template_directory() . 'temp/vendors/wp-inisiat-board/functions-inisiat_lomer.php';
}






	require get_template_directory() . 'temp/widgets/search.php';
	require get_template_directory() . 'temp/widgets/socials.php';

	


	define( 'temp_FRAMEWORK_ACTIVED', true );
}


require get_template_directory() . 'temp/vendors/elem/functions.php';


function temp_register_post_types($post_types) {
	foreach ($post_types as $key => $post_type) {
		if ( $post_type == 'brand' || $post_type == 'testimonial' ) {
			unset($post_types[$key]);
		}
	}
	if ( !in_array('header', $post_types) ) {
		$post_types[] = 'header';
	}
	return $post_types;
}
add_filter( 'tempus_framework_register_post_types', 'temp_register_post_types' );
