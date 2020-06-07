<?php
/**

 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php textinfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php textinfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="wrapper-container" class="wrapper-container">

	<div id="temp-main-content">
		<section id="main-container" class="main-content container-fluid inner">
			
			<?php
			
				while ( have_posts() ) : the_post();
					the_content();

				endwhile;
			?>
		</section>
	</div><!-- .site -->
</div>
<?php wp_footer(); ?>
</body>
</html>