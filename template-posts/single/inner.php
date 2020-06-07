<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <div class="post-layout detail-top">
        <?php if( $post_format == 'link' ) {
            $format = temp_post_format_link_helper( get_the_content(), get_the_title() );
            $title = $format['title'];
            $link = temp_get_link_attributes( $title );
            $thumb = temp_post_thumbnail('', $link);
            echo trim($thumb);
        } elseif( has_post_thumbnail() ) { ?>
            <div class="top-image">
                <div class="entry-thumb <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
                    <?php
                        $thumb = temp_post_thumbnail();
                        echo trim($thumb);
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php temp_post_categories($post); ?>
        <?php if (get_the_title()) { ?>
            <h1 class="entry-title">
                <?php the_title(); ?>
            </h1>
        <?php } ?>
        <div class="top-info">
            <a href="<?php the_permalink(); ?>"><i class="flaticon-clock"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
   
        </div>
    </div>

	<div class="entry-content-detail">
    	<div class="single-info info-bottom">
            <div class="entry-description">
                <?php
                    
                        the_content();
                ?>
            </div><!-- /entry-content -->
 
            <?php  
                $posttags = get_the_tags();
            ?>
            <?php if( !empty($posttags) || temp_get_config('show_text_social_share', false) ){ ?>
        		<div class="tag-social clearfix">
                    <?php temp_post_tags(); ?>
        			<?php if( temp_get_config('show_text_social_share', false) ) {
        				get_template_part( 'template-parts/sharebox' );
        			} ?>
        		</div>
            <?php } ?>

    	</div>
    </div>
</article>