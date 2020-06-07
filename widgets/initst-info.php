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

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$sala = WP_inisiat_Board_inisiat_Listing::get_sala_html($post->ID);
$custom_fields = WP_inisiat_Board_Post_Type_inisiat_Custom_Fields::get_custom_fields('inisiat_cfield');
?>
<div class="inisiat-detail-detail in-sidebar">
    <ul class="list">
        <?php if ( $sala ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon"></i>
                </div>
           
            </li>
        <?php } ?>
        <?php if ( $custom_fields ) { ?>
            <?php foreach ($custom_fields as $cpost) {
                $meta_key = WP_inisiat_Board_Post_Type_inisiat_Custom_Fields::generate_key_id(WP_inisiat_BOARD_inisiat_LISTING_PREFIX, $cpost->post_name);
                $value = get_post_meta( $post->ID, $meta_key, true );
                $icon_class = get_post_meta( $cpost->ID, WP_inisiat_BOARD_inisiat_CUSTOM_FIELD_PREFIX .'icon_class', true );

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
    </ul>
</div>