<?php

global $post;
wp_enqueue_script('addthis');
?>
<div class="tempus-social-share">
		<div class="bo-social-icons bo-sicolor social-radius-rounded">
		<span class="title"><?php echo esc_html__('Поделиться:','temp'); ?> </span>
		

		<?php if ( temp_get_config('facebook_share', 1) ): ?>
 			<a href="javascript:void(0);" data-original-title="facebook" class="bo-social-facebook addthis_button_facebook"><i class="fa fa-facebook"></i></a>
		<?php endif; ?>
		<?php if ( temp_get_config('twitter_share', 1) ): ?>
 			<a href="javascript:void(0);" data-original-title="twitter" class="bo-social-twitter addthis_button_twitter"><i class="fa fa-twitter"></i></a>
		<?php endif; ?>
		<?php if ( temp_get_config('vk_share', 1) ): ?>
 			<a href="javascript:void(0);" data-original-title="vk" class="bo-social-vk addthis_button_vk"><i class="fa fa-vk"></i></a>
		<?php endif; ?>
	</div>
</div>	