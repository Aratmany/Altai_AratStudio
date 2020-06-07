<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'inisiat_lomer' ) {
    return;
}
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$views = get_post_meta(get_the_ID(), WP_inisiat_BOARD_inisiat_lomer_PREFIX.'views_count', true );

$address = get_post_meta(get_the_ID(), WP_inisiat_BOARD_inisiat_lomer_PREFIX.'address', true );
$categories = get_the_terms( get_the_ID(), 'inisiat_lomer_category' );

$sala = WP_inisiat_Board_inisiat_lomer::get_sala_html($post->ID);
$custom_fields = WP_inisiat_Board_Post_Type_inisiat_Custom_Fields::get_custom_fields('inisiat_lomer_cfield');
?>
<div class="inisiat-detail-detail in-sidebar">
    <ul class="list">
        <?php if ( $sala ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-ia"></i>
                </div>
                <div class="details">
                    <div class="value"><?php echo wp_kses_post($sala); ?></div>
                </div>
            </li>
        <?php } ?>
        <?php if ( $custom_fields ) { ?>
            <?php foreach ($custom_fields as $cpost) {
                $value = get_post_meta( $post->ID, WP_inisiat_BOARD_inisiat_lomer_PREFIX .'custom_'. $cpost->post_name, true );
                $icon_class = get_post_meta( $cpost->ID, WP_inisiat_BOARD_inisiat_lomer_CUSTOM_FIELD_PREFIX .'icon_class', true );
                
                if ( !empty($value) ) {
                    ?>
                    <li>
                        <div class="icon">
                            <?php if ( !empty($icon_class) ) { ?>
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            <?php } ?>
                        </div>
                        <div class="details">
                            <div class="text"><?php echo wp_kses_post($cpost->post_title); ?></div>
                            <div class="value"><?php echo WP_inisiat_Board_Post_Type_inisiat_Custom_Fields::display_field($cpost, $value); ?></div>
                        </div>
                    </li>
                    <?php
                }
            ?>
                
            <?php } ?>
        <?php } ?>

        <?php if ( $views ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-eye"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Просмотров', 'temp'); ?></div>
                    <div class="value"><?php echo wp_kses_post($views); ?></div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>