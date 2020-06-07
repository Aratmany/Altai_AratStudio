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

$author_id = $post->post_author;
$lom_id = WP_inisiat_Board_User::get_lom_by_user_id($author_id);
if ( empty($lom_id) ) {
    return;
}
$address = get_post_meta($lom_id, WP_inisiat_BOARD_lom_PREFIX.'address', true);
$phone = get_post_meta($lom_id, WP_inisiat_BOARD_lom_PREFIX.'phone', true);
$email = get_post_meta($lom_id, WP_inisiat_BOARD_lom_PREFIX.'email', true);
?>
<div class="inisiat-detail-lom-info">

    <?php if ( has_post_thumbnail($lom_id) ) { ?>
        <div class="lom-thumbnail">
            <?php echo get_the_post_thumbnail( $lom_id, 'thumbnail' ); ?>
        </div>
    <?php } ?>


    <?php if ( !empty($address) ) { ?>
        <div class="lom-address">
            <?php echo wp_kses_post($address); ?>
        </div>
    <?php } ?>
    <?php if ( !empty($phone) || !empty($email) ) { ?>
        <div class="bottom-inner">
    <?php } ?>
        <?php if ( !empty($phone) ) { ?>
            <div class="lom-phone">
                <?php echo wp_kses_post($phone); ?>
            </div>
        <?php } ?>
        <?php if ( !empty($email) ) { ?>
            <div class="lom-email">
                <?php echo wp_kses_post($email); ?>
            </div>
        <?php } ?>
    <?php if ( !empty($phone) || !empty($email) ) { ?>
        </div>
    <?php } ?>
</div>