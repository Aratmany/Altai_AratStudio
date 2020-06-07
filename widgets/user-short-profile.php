<?php 
if ( !is_user_logged_in() || !class_exists('WP_inisiat_Board_User') ) {
    return;
}

$title = apply_filters('widget_title', $instance['title']);
if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$user_id = get_current_user_id();
if ( WP_inisiat_Board_User::is_lom($user_id) ) {
    $lom_id = WP_inisiat_Board_User::get_lom_by_user_id($user_id);
    if ( has_post_thumbnail($lom_id) ) {
        $logo = get_the_post_thumbnail( $lom_id, 'thumbnail' );
    }
    $title = get_the_title($lom_id);
    $locations = get_the_terms( $lom_id, 'lom_location' );

    if ($nav_menu_lom) {
        $term = get_term_by( 'slug', $nav_menu_lom, 'nav_menu' );
        if ( !empty($term) ) {
            $nav_menu_id = $term->term_id;
        }
    }
} elseif ( WP_inisiat_Board_User::is_inisiat_lomer() ) {
    $inisiat_lomer_id = WP_inisiat_Board_User::get_inisiat_lomer_by_user_id($user_id);
    if ( has_post_thumbnail($inisiat_lomer_id) ) {
        $logo = get_the_post_thumbnail( $inisiat_lomer_id, 'thumbnail' );
    }
    $title = get_the_title($inisiat_lomer_id);
    $locations = get_the_terms( $inisiat_lomer_id, 'inisiat_lomer_location' );

    if ($nav_menu_inisiat_lomer) {
        $term = get_term_by( 'slug', $nav_menu_inisiat_lomer, 'nav_menu' );
        if ( !empty($term) ) {
            $nav_menu_id = $term->term_id;
        }
    }
    $profile_percents = WP_inisiat_Board_User::compute_profile_percent($inisiat_lomer_id);
} else {
    return;
}
?>
<div class="user-short-profile widget clearfix <?php echo esc_attr( (WP_inisiat_Board_User::is_inisiat_lomer($user_id))? 'is_inisiat_lomer flex-middle': ''); ?>">
    <?php
        if ( !empty($logo) ) {
            ?>
            <div class="user-logo"><?php echo wp_kses_post($logo); ?></div>
            <?php
        }
    ?>
    <div class="inner">
        <?php
            if ( $title ) {
                ?>
                <h3 class="title"><?php echo wp_kses_post($title); ?></h3>
                <?php
            } ?>
            <?php if ( $locations ) {
                $terms = array();
                temp_locations_walk($locations, 0, $terms);
            ?>
                <div class="location">
                    <i class="flaticon-location-pin"></i>
                    <?php 
                    $i=1; foreach ($terms as $term) { ?>
                        <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($terms) ? ', ' : '' ); ?>
                    <?php $i++; } ?>
                </div>
            <?php
            }
        ?>
    </div>
</div>
<?php if ( $nav_menu_id ) { ?>
    <div class="tempus_custom_menu widget">
        <?php
            $args = array(
                'menu'        => $nav_menu_id,
                'container_class' => 'navbar-collapse no-padding',
                'menu_class' => 'custom-menu',
                'fallback_cb' => '',
                'walker' => new temp_Nav_Menu()
            );
            wp_nav_menu($args);
        ?>
    </div>
<?php } ?>
<?php if ( !empty($profile_percents) ) { ?>

<?php } ?>