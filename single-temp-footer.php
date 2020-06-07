
<?php wp_head(); ?>

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