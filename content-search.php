<?php

?>
<article <?php post_class('post post-layout post-list-item'); ?>>
    <div class="list-inner">
        <div class="col-content-full">
            <?php if (get_the_title()) { ?>
                <h4 class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
            <?php } ?>
            <div class="top-info">
                <a href="<?php the_permalink(); ?>"><i class="flaticon-clock"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
                <span class="texter"><i class="flaticon-chat"></i><?php texter_number( esc_html__('0 texter', 'temp'), esc_html__('% texter', 'temp') ); ?></span>
            </div>
          
        </div>
    </div>
</article>